<?php

namespace App\Services;

use App\Models\School;
use App\Models\SocialLink;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SocialLinkService
{
    /**
     * @param array $data
     *
     * @return SocialLink|Model
     */
    public function createSocialLink(array $data): SocialLink|Model
    {
        $data['social_linkable_type'] = School::class;
        $data['social_linkable_id'] = $data['school_id'];
        $socialLink = SocialLink::query()->create($data);

        return $socialLink;
    }

    /**
     * @param int $socialLinkId
     * @param array $data
     *
     * @return SocialLink|Model|Collection|null
     */
    public function updateSocialLink(int $socialLinkId, array $data): SocialLink|Model|Collection|null
    {
        $socialLink = SocialLink::query()->find($socialLinkId);
        $socialLink->update($data);

        return $socialLink;
    }

    /**
     * @param int $socialLinkId
     *
     * @return mixed
     */
    public function removeSocialLink(int $socialLinkId): mixed
    {
        return SocialLink::query()->where('id', $socialLinkId)->delete();
    }
}
