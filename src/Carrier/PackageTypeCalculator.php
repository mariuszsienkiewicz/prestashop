<?php

namespace Gett\MyparcelBE\Carrier;

use Carrier;
use Cart;
use Gett\MyparcelBE\Constant;
use Gett\MyparcelBE\Module\Carrier\ExclusiveField;
use Gett\MyparcelBE\Service\CarrierConfigurationProvider;
use Gett\MyparcelBE\Service\ProductConfigurationProvider;

class PackageTypeCalculator extends AbstractPackageCalculator
{
    public function getOrderPackageType(int $id_order, int $id_carrier)
    {
        $package_types = array_unique($this->getOrderProductsPackageTypes($id_order));

        if ($package_types) {
            return min($package_types);
        }

        $packageType = (int) CarrierConfigurationProvider::get(
            $id_carrier, Constant::PACKAGE_TYPE_CONFIGURATION_NAME
        );

        return $packageType ?: 1;
    }

    public function allowDeliveryOptions(Cart $cart, string $countryIso)
    {
        if (empty($cart->id) || empty($cart->id_carrier)) {
            return false;
        }
        $carrier = new Carrier($cart->id_carrier);
        if (empty($carrier->id)) {
            return false;
        }

        $carrierPackageTypes = $this->getCarrierPackageTypes($carrier, $countryIso);
        if (empty($carrierPackageTypes)) {
            return false;
        }
        // If only parcel type is set then return true
        if (count($carrierPackageTypes) === 1 && $carrierPackageTypes[0] === Constant::PACKAGE_TYPE_PACKAGE) {
            return true;
        }

        $productsPackageTypes = $this->getProductsPackageTypes($cart, $countryIso);
        if (empty($productsPackageTypes)) {
            return true;
        }

        // 1. At least 1 product in cart is of type parcel, regardless of weight: order is considered parcel
        if (in_array(Constant::PACKAGE_TYPE_PACKAGE, $productsPackageTypes)) {
            return true; // delivery options
        }

        // 2. Only products in cart of type letter, regardless of total weight: order is considered letter
        if (count($productsPackageTypes) === 1 && in_array(Constant::PACKAGE_TYPE_LETTER, $productsPackageTypes)) {
            return false; // no delivery options
        }

        // 3. Total weight is above 2 Kg, regardless of package types, order is considered parcel
        $weight = $cart->getTotalWeight();
        if ($weight >= Constant::PACKAGE_TYPE_WEIGHT_LIMIT) {
            return true; // delivery options
        }

        // 4. Products of type letter, digital stamp, mailbox package AND total weight is less than 2 Kg
        return false; // no delivery options
    }

    private function getOrderProductsPackageTypes(int $id_order)
    {
        $result = $this->getOrderProductsConfiguration($id_order);
        $package_types = [];
        foreach ($result as $item) {
            if ($item['name'] == 'MYPARCELBE_PACKAGE_TYPE' && $item['value']) {
                $package_types[$item['id_product']] = (int) $item['value'];
            }
        }

        return $package_types;
    }

    private function getCarrierPackageTypes(Carrier $carrier, string $countryIso)
    {
        $exclusiveField = new ExclusiveField();
        $carrierType = $exclusiveField->getCarrierType($carrier);
        $packageTypes = [];
        foreach (Constant::PACKAGE_TYPES as $packageType => $packageName) {
            if ($exclusiveField->isAvailable(
                $countryIso,
                $carrierType,
                Constant::PACKAGE_TYPE_CONFIGURATION_NAME
            )) {
                $packageTypes[] = $packageType;
            }
        }

        return $packageTypes;
    }

    private function getProductsPackageTypes(Cart $cart, string $countryIso)
    {
        $products = $cart->getProducts();
        if (empty($products)) {
            return [];
        }
        $types = [];
        foreach ($products as $product) {
            $type = (int) ProductConfigurationProvider::get(
                (int) $product['id_product'],
                Constant::PACKAGE_TYPE_CONFIGURATION_NAME,
                Constant::PACKAGE_TYPE_PACKAGE
            );
            if (!in_array($type, $types)) {
                $types[] = $type;
            }
        }

        return $types;
    }
}
