<?php

declare(strict_types=1);

namespace PoPSitesWassup\SocialNetworkMutations\MutationResolverBridges;

use Symfony\Contracts\Service\Attribute\Required;
use PoP\ComponentModel\Instances\InstanceManagerInterface;
use PoP\ComponentModel\MutationResolution\MutationResolutionManagerInterface;
use PoP\Hooks\HooksAPIInterface;
use PoP\Translation\TranslationAPIInterface;
use PoPSchema\Users\Constants\InputNames;
use PoPSchema\Users\TypeAPIs\UserTypeAPIInterface;

abstract class AbstractUserUpdateUserMetaValueMutationResolverBridge extends AbstractUpdateUserMetaValueMutationResolverBridge
{
    protected UserTypeAPIInterface $userTypeAPI;

    #[Required]
    public function autowireAbstractUserUpdateUserMetaValueMutationResolverBridge(
        UserTypeAPIInterface $userTypeAPI,
    ): void {
        $this->userTypeAPI = $userTypeAPI;
    }

    protected function getRequestKey()
    {
        return InputNames::USER_ID;
    }
}
