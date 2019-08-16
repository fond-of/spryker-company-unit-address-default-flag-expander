<?php

namespace FondOfSpryker\Zed\CompanyUnitAddressDefaultFlagExpander\Communication\Plugin\CompanyBusinessUnitExtension;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
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
        $defaultBillingAddress = $companyBusinessUnitTransfer->getDefaultBillingAddress();
        $companyUnitAddressCollectionTransfer = $companyBusinessUnitTransfer->getAddressCollection();

        if ($companyUnitAddressCollectionTransfer === null || $defaultBillingAddress === null) {
            return $companyBusinessUnitTransfer;
        }

        foreach ($companyUnitAddressCollectionTransfer->getCompanyUnitAddresses() as $companyUnitAddressTransfer) {
            if ($companyUnitAddressTransfer->getIdCompanyUnitAddress() !== $defaultBillingAddress) {
                continue;
            }

            $companyUnitAddressTransfer->setIsDefaultBilling(true)
                ->setIsDefaultShipping(true);

            break;
        }

        return $companyBusinessUnitTransfer;
    }
}
