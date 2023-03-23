<?php

declare(strict_types=1);

use MyParcelNL\Pdk\Facade\RenderService;

/**
 * This controller is used to show a tab under "Shipping" in the admin.
 *
 * @property \MyParcelNL $module
 */
class AdminMyParcelNLController extends AdminController
{
    public function __construct()
    {
        $this->bootstrap         = true;
        $this->multishop_context = Shop::CONTEXT_ALL;
        $this->show_toolbar      = true;

        MyParcelNL::getModule();

        parent::__construct();
    }

    /**
     * @return void
     */
    public function initContent(): void
    {
        parent::initContent();

        $this->context->smarty->assign([
            'content' => RenderService::renderPluginSettings(),
        ]);
    }

    public function initToolbar()
    {
        parent::initToolbar();

        $this->toolbar_btn['erase'] = [
            'short' => 'Erase',
            'desc'  => $this->trans('Erase all', [], 'Admin.Advparameters.Feature'),
        ];
    }
}