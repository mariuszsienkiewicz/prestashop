<?php

declare(strict_types=1);

namespace MyParcelNL\PrestaShop\Module\Hooks;

use Address;
use Country;
use Db;
use Gett\MyparcelBE\Constant;
use Gett\MyparcelBE\Database\Table;
use MyParcelNL\Pdk\App\Api\Backend\PdkBackendActions;
use MyParcelNL\Pdk\App\Order\Contract\PdkProductRepositoryInterface;
use MyParcelNL\Pdk\Base\Model\ContactDetails;
use MyParcelNL\Pdk\Facade\Actions;
use MyParcelNL\Pdk\Facade\Frontend;
use MyParcelNL\Pdk\Facade\Pdk;
use MyParcelNL\Pdk\Frontend\Contract\ScriptServiceInterface;
use MyParcelNL\Pdk\Frontend\Contract\ViewServiceInterface;
use MyParcelNL\PrestaShop\Grid\Column\LabelsColumn;
use MyParcelNL\PrestaShop\Pdk\Order\Repository\PdkOrderRepository;
use MyParcelNL\PrestaShop\Pdk\Order\Repository\PsCartRepository;
use MyParcelNL\PrestaShop\Repository\PsCarrierMappingRepository;
use PrestaShop\PrestaShop\Core\Grid\Record\RecordCollection;
use Tools;

trait HasPdkRenderHooks
{
    /**
     * Renders the module configuration page.
     *
     * @return string
     */
    public function getContent(): string
    {
        return Frontend::renderPluginSettings();
    }

    /**
     * @param $params
     *
     * @return void
     * @throws \Exception
     */
    public function hookActionCarrierProcess($params)
    {
        $options = Tools::getValue(Pdk::get('checkoutHiddenInputName'));

        if (! $options || '[]' === $options) {
            return;
        }

        /**
         * @var \PrestaShop\PrestaShop\Adapter\Entity\Cart $cart
         */
        $cart = $params['cart'];

        $optionsArray    = json_decode($options, true);
        $deliveryOptions = $this->createDeliveryOptions($optionsArray);

        $action    = Tools::getValue('action');
        $carrierId = Tools::getValue('delivery_option');

        if (('selectDeliveryOption' === $action && ! empty($carrierId)) || Tools::isSubmit('confirmDeliveryOption')) {
            $this->saveDeliveryOptions($cart->id, $deliveryOptions);
        }
    }

    public function hookActionOrderGridDefinitionModifier(array $params): void
    {
        /** @var \PrestaShop\PrestaShop\Core\Grid\Definition\GridDefinitionInterface $definition */
        $definition = $params['definition'];

        $appInfo = Pdk::getAppInfo();

        $definition
            ->getColumns()
            ->addBefore(
                'actions',
                (new LabelsColumn($appInfo->name))
                    ->setName($appInfo->title)
            );

        //        $bulkActions = $definition->getBulkActions();
        //        foreach ($this->getBulkActionsMap() as $action => $data) {
        //            $bulkActions->add(
        //                (new IconBulkAction($action))
        //                    ->setName(Language::translate($data['label']))
        //                    ->setOptions(['icon' => $data['icon']])
        //            );
        //        }
    }

    /**
     * Renders MyParcel buttons in order grid.
     *
     * @param  array $params
     *
     * @return void
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     * @throws \Exception
     */
    public function hookActionOrderGridPresenterModifier(array &$params): void
    {
        $params['presented_grid']['data']['records'] = new RecordCollection(
            array_map(static function (array $row) {
                /** @var PdkOrderRepository $repository */
                $repository = Pdk::get(PdkOrderRepository::class);
                $order      = $repository->get($row['id_order']);

                $row['myparcel'] = Frontend::renderOrderListItem($order);

                return $row;
            }, $params['presented_grid']['data']['records']->all())
        );
    }

    /**
     * @param  array $params
     *
     * @return void
     * @todo move to separate hooks file
     */
    public function hookActionProductUpdate(array $params): void
    {
        $productId               = (int) $params['id_product'];
        $postValues              = Tools::getAllValues();
        $myparcelProductSettings = array_filter($postValues, static function ($key) {
            return str_starts_with($key, 'myparcelnl');
        }, ARRAY_FILTER_USE_KEY);

        $productSettingsBody = [];

        foreach ($myparcelProductSettings as $key => $value) {
            $explodedKey                  = explode('-', $key);
            $newKey                       = end($explodedKey);
            $productSettingsBody[$newKey] = $value;
        }

        // todo: refactor to use a \Symfony\Component\HttpFoundation\Request, pass body as json with data.product_settings[0]
        Actions::execute(PdkBackendActions::UPDATE_PRODUCT_SETTINGS, [
            'productId'       => $productId,
            'productSettings' => $productSettingsBody,
        ]);
    }

    /**
     * Renders the notification area.
     *
     * @noinspection PhpUnused
     * @return string
     */
    public function hookDisplayAdminAfterHeader(): string
    {
        $html = Frontend::renderNotifications();
        $html .= Frontend::renderModals();

        return $html;
    }

    /**
     * @return string
     * @noinspection PhpUnused
     */
    public function hookDisplayAdminEndContent(): string
    {
        return Frontend::renderInitScript();
    }

    /**
     * Renders the shipment card on a single order page.
     *
     * @param  array $params
     *
     * @return string
     * @throws \Doctrine\ORM\ORMException
     * @throws \PrestaShopDatabaseException
     * @throws \PrestaShopException
     */
    public function hookDisplayAdminOrderMain(array $params): string
    {
        /** @var \MyParcelNL\PrestaShop\Pdk\Order\Repository\PdkOrderRepository $repository */
        $repository = Pdk::get(PdkOrderRepository::class);
        $order      = $repository->get($params['id_order']);

        return Frontend::renderOrderBox($order);
    }

    /**
     * Renders the product settings.
     *
     * @param  array $params
     *
     * @return string
     */
    public function hookDisplayAdminProductsExtra(array $params): string
    {
        /** @var \MyParcelNL\Pdk\App\Order\Contract\PdkProductRepositoryInterface $repository */
        $repository          = Pdk::get(PdkProductRepositoryInterface::class);
        $product             = $repository->getProduct($params['id_product']);
        $productSettingsView = Frontend::renderProductSettings($product);

        $this->context->smarty->assign(
            [
                'productSettingsView' => $productSettingsView,
            ]
        );

        // todo move to twig
        return $this->display($this->name, 'views/templates/hook/product_settings.tpl');
    }

    /**
     * Load the js and css files of the admin app.
     *
     * @return void
     */
    public function hookDisplayBackOfficeHeader(): void
    {
        /** @var ScriptServiceInterface $scriptService */
        $scriptService = Pdk::get(ScriptServiceInterface::class);

        /** @var \AdminControllerCore $controller */
        $controller = $this->context->controller;

        $scriptService->addForAdminHeader($controller, $this->_path);
    }

    /**
     * @param $params
     *
     * @return false|string
     * @throws \PrestaShop\PrestaShop\Core\Localization\Exception\LocalizationException
     * @throws \Exception
     */
    public function hookDisplayCarrierExtraContent($params)
    {
        /** @var PsCartRepository $cartRepository */
        $cartRepository = Pdk::get(PsCartRepository::class);

        if (empty($this->context->cart->id_carrier)) {
            $selectedDeliveryOption          = current($this->context->cart->getDeliveryOption(null, false, false));
            $this->context->cart->id_carrier = (int) $selectedDeliveryOption;
        }

        $shippingAddress = $this->getContactDetails(new Address($this->context->cart->id_address_delivery));
        $billingAddress  = $this->getContactDetails(new Address($this->context->cart->id_address_invoice));

        $this->context->smarty->setEscapeHtml(false);

        $this->context->smarty->assign([
            'deliveryOptions' => Frontend::renderDeliveryOptions($cartRepository->get($this->context->cart)),
            'shippingAddress' => $this->encodeAddress($shippingAddress),
            'billingAddress'  => $this->encodeAddress($billingAddress),
            'carrier'         => $this->getCarrierName((int) $this->context->cart->id_carrier),
        ]);

        return $this->display($this->name, 'views/templates/hook/carrier.tpl');
    }

    public function hookHeader()
    {
        /** @var \MyParcelNL\Pdk\Frontend\Contract\ViewServiceInterface $viewService */
        $viewService = Pdk::get(ViewServiceInterface::class);

        if (! $viewService->isCheckoutPage()) {
            return;
        }

        $this->loadCoreScripts();

        $this->loadDeliveryOptionsScripts();
    }

    private function createDeliveryOptions(array $deliveryOptions): array
    {
        return [
            'carrier'         => $deliveryOptions['carrier'] ?? null,
            'date'            => $deliveryOptions['date'] ?? null,
            'pickupLocation'  => null,
            'shipmentOptions' => $deliveryOptions['shipmentOptions'] ?? null,
            'deliveryType'    => $deliveryOptions['deliveryType'] ?? null,
            'packageType'     => $deliveryOptions['packageType'] ?? null,
        ];
    }

    private function encodeAddress(ContactDetails $contactDetails): string
    {
        return htmlspecialchars(
            json_encode(array_filter($contactDetails->toArray())),
            ENT_QUOTES,
            'UTF-8'
        );
    }

    private function getCarrierName(int $carrierId): string
    {
        /** @var \MyParcelNL\PrestaShop\Repository\PsCarrierMappingRepository $carrierRepository */
        $carrierRepository = Pdk::get(PsCarrierMappingRepository::class);
        $fromCarrierConfig = $carrierRepository->findOneBy(['idCarrier' => $carrierId]);

        if ($fromCarrierConfig) {
            return $fromCarrierConfig->getMyparcelCarrier();
        }

        return 'postnl';
    }

    private function getContactDetails(Address $address): ContactDetails
    {
        return new ContactDetails([
            'boxNumber'            => null,
            'cc'                   => Country::getIsoById($address->id_country),
            'city'                 => $address->city,
            'fullStreet'           => $address->address1,
            'number'               => null,
            'numberSuffix'         => null,
            'postalCode'           => $address->postcode,
            'region'               => null,
            'state'                => null,
            'street'               => null,
            'streetAdditionalInfo' => null,
            'person'               => $address->firstname . ' ' . $address->lastname,
            'email'                => $this->context->customer->email,
            'phone'                => $address->phone,
        ]);
    }

    private function loadCoreScripts(): void
    {
        $this->context->controller->addJS("{$this->_path}views/js/frontend/checkout-core/lib/checkout-core.iife.js");
        $this->context->controller->addCSS("{$this->_path}views/js/frontend/checkout-core/lib/style.css");
    }

    private function loadDeliveryOptionsScripts(): void
    {
        $version = Pdk::get('deliveryOptionsVersion');

        $this->context->controller->registerJavascript(
            'myparcelnl-delivery-options',
            sprintf('https://unpkg.com/@myparcel/delivery-options@%s/dist/myparcel.js', $version),
            ['server' => 'remote', 'position' => 'head', 'priority' => 1]
        );

        $this->context->controller->addJS(
            "{$this->_path}views/js/frontend/checkout-delivery-options/lib/checkout-delivery-options.iife.js"
        );
        $this->context->controller->addCSS("{$this->_path}views/js/frontend/checkout-delivery-options/lib/style.css");
    }

    /**
     * @param  int   $cartId
     * @param  array $deliveryOptions
     *
     * @return void
     * @todo do this using entities
     */
    private function saveDeliveryOptions(int $cartId, array $deliveryOptions): void
    {
        $values = [
            'id_cart'          => $cartId,
            'delivery_options' => pSQL(json_encode($deliveryOptions)),
        ];

        Db::getInstance(_PS_USE_SQL_SLAVE_)
            ->update(
                'myparcelnl_delivery_options',
                $values,
                false,
                true,
                Db::REPLACE
            );
    }
}
