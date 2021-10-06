<?php

declare(strict_types=1);

namespace PoPSitesWassup\SocialNetworkMutations\MutationResolvers;

use PoPSchema\PostTags\TypeAPIs\PostTagTypeAPIInterface;
use Symfony\Contracts\Service\Attribute\Required;

abstract class AbstractSubscribeToOrUnsubscribeFromTagMutationResolver extends AbstractUpdateUserMetaValueMutationResolver
{
    protected PostTagTypeAPIInterface $postTagTypeAPI;

    #[Required]
    final public function autowireAbstractSubscribeToOrUnsubscribeFromTagMutationResolver(
        PostTagTypeAPIInterface $postTagTypeAPI,
    ): void {
        $this->postTagTypeAPI = $postTagTypeAPI;
    }

    public function validateErrors(array $form_data): array
    {
        $errors = parent::validateErrors($form_data);
        if (!$errors) {
            $target_id = $form_data['target_id'];

            // Make sure the post exists
            $target = $this->postTagTypeAPI->getTag($target_id);
            if (!$target) {
                $errors[] = $this->translationAPI->__('The requested topic/tag does not exist.', 'pop-coreprocessors');
            }
        }
        return $errors;
    }

    protected function additionals($target_id, $form_data): void
    {
        $this->hooksAPI->doAction('gd_subscritetounsubscribefrom_tag', $target_id, $form_data);
        parent::additionals($target_id, $form_data);
    }
}
