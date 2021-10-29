<?php

declare(strict_types=1);

namespace PoPSitesWassup\SocialNetworkMutations\MutationResolverBridges;

use PoP\ApplicationTaxonomies\FunctionAPIFactory;
use PoP\ComponentModel\MutationResolvers\MutationResolverInterface;
use PoPSchema\PostTags\TypeAPIs\PostTagTypeAPIInterface;
use PoPSitesWassup\SocialNetworkMutations\MutationResolvers\SubscribeToTagMutationResolver;
use Symfony\Contracts\Service\Attribute\Required;

class SubscribeToTagMutationResolverBridge extends AbstractTagUpdateUserMetaValueMutationResolverBridge
{
    private ?SubscribeToTagMutationResolver $subscribeToTagMutationResolver = null;
    private ?PostTagTypeAPIInterface $postTagTypeAPI = null;

    public function setSubscribeToTagMutationResolver(SubscribeToTagMutationResolver $subscribeToTagMutationResolver): void
    {
        $this->subscribeToTagMutationResolver = $subscribeToTagMutationResolver;
    }
    protected function getSubscribeToTagMutationResolver(): SubscribeToTagMutationResolver
    {
        return $this->subscribeToTagMutationResolver ??= $this->instanceManager->getInstance(SubscribeToTagMutationResolver::class);
    }
    public function setPostTagTypeAPI(PostTagTypeAPIInterface $postTagTypeAPI): void
    {
        $this->postTagTypeAPI = $postTagTypeAPI;
    }
    protected function getPostTagTypeAPI(): PostTagTypeAPIInterface
    {
        return $this->postTagTypeAPI ??= $this->instanceManager->getInstance(PostTagTypeAPIInterface::class);
    }

    //#[Required]
    final public function autowireSubscribeToTagMutationResolverBridge(
        SubscribeToTagMutationResolver $subscribeToTagMutationResolver,
        PostTagTypeAPIInterface $postTagTypeAPI,
    ): void {
        $this->subscribeToTagMutationResolver = $subscribeToTagMutationResolver;
        $this->postTagTypeAPI = $postTagTypeAPI;
    }

    public function getMutationResolver(): MutationResolverInterface
    {
        return $this->getSubscribeToTagMutationResolver();
    }

    protected function onlyExecuteWhenDoingPost(): bool
    {
        return false;
    }

    public function getSuccessString(string | int $result_id): ?string
    {
        $applicationtaxonomyapi = FunctionAPIFactory::getInstance();
        $tag = $this->getPostTagTypeAPI()->getTag($result_id);
        return sprintf(
            $this->translationAPI->__('You have subscribed to <em><strong>%s</strong></em>.', 'pop-coreprocessors'),
            $applicationtaxonomyapi->getTagSymbolName($tag)
        );
    }
}
