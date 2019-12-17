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
        $companyUnitAddressCollectionTransfer = $companyBusinessUnitTransfer->getAddressCollection();

        if ($companyUnitAddressCollectionTransfer === null) {
            return $companyBusinessUnitTransfer;
        }

        foreach ($companyUnitAddressCollectionTransfer->getCompanyUnitAddresses() as $companyUnitAddressTransfer) {
            $this->setAddressBoolValue($companyUnitAddressTransfer, $idDefaultBillingAddress);
        }

        return $companyBusinessUnitTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUnitAddressTransfer $companyUnitAddressTransfer
     * @param int $idDefaultBillingAddress
     *
     * @return \Generated\Shared\Transfer\CompanyUnitAddressTransfer
     */
    protected function setAddressBoolValue(
        CompanyUnitAddressTransfer $companyUnitAddressTransfer,
        int $idDefaultBillingAddress
    ): CompanyUnitAddressTransfer {

        if ($companyUnitAddressTransfer->getIdCompanyUnitAddress() === $idDefaultBillingAddress) {
            return $companyUnitAddressTransfer->setIsDefaultBilling(true)
                ->setIsDefaultShipping(true);
        }

        return $companyUnitAddressTransfer->setIsDefaultBilling(false)
            ->setIsDefaultShipping(false);
    }
}
