<?php

namespace FondOfSpryker\Zed\CompanyUnitAddressDefaultFlagExpander\Communication\Plugin\CompanyBusinessUnitExtension;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyUnitAddressTransfer;
use Spryker\Zed\CompanyBusinessUnitExtension\Dependency\Plugin\CompanyBusinessUnitExpanderPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

class DefaultAddressFlagCompanyBusinessUnitExpanderPlugin extends AbstractPlugin implements CompanyBusinessUnitExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function expand(CompanyBusinessUnitTransfer $companyBusinessUnitTransfer): CompanyBusinessUnitTransfer
    {
        $idDefaultBillingAddress = $companyBusinessUnitTransfer->getDefaultBillingAddress();
        $idDefaultShipingAddress = $companyBusinessUnitTransfer->getDefaultShippingAddress();

        if ($idDefaultBillingAddress === null && $idDefaultShipingAddress === null) {
            return $companyBusinessUnitTransfer;
        }

        $companyUnitAddressCollectionTransfer = $companyBusinessUnitTransfer->getAddressCollection();

        if ($companyUnitAddressCollectionTransfer === null) {
            return $companyBusinessUnitTransfer;
        }

        foreach ($companyUnitAddressCollectionTransfer->getCompanyUnitAddresses() as $companyUnitAddressTransfer) {
            $this->setAddressBoolValue(
                $companyUnitAddressTransfer,
                $idDefaultBillingAddress,
                $idDefaultShipingAddress
            );
        }

        return $companyBusinessUnitTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUnitAddressTransfer $companyUnitAddressTransfer
     * @param int|null $idDefaultBillingAddress
     * @param int|null $idDefaultShippingAddress
     * @return \Generated\Shared\Transfer\CompanyUnitAddressTransfer
     */
    protected function setAddressBoolValue(
        CompanyUnitAddressTransfer $companyUnitAddressTransfer,
        ?int $idDefaultBillingAddress,
        ?int $idDefaultShippingAddress
    ): CompanyUnitAddressTransfer {

        $companyUnitAddressTransfer
            ->setIsDefaultBilling(false)
            ->setIsDefaultShipping(false);

        if ($companyUnitAddressTransfer->getIdCompanyUnitAddress() != null
            && $companyUnitAddressTransfer->getIdCompanyUnitAddress() === $idDefaultBillingAddress) {
            $companyUnitAddressTransfer->setIsDefaultBilling(true);
        }

        if ($companyUnitAddressTransfer->getIdCompanyUnitAddress() != null
            && $companyUnitAddressTransfer->getIdCompanyUnitAddress() === $idDefaultShippingAddress) {
            $companyUnitAddressTransfer->setIsDefaultShipping(true);
        }

        return $companyUnitAddressTransfer;
    }
}
