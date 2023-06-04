<?php

namespace App\Model\Guilded;

class Media
{
    
    private int       $id;
    private string    $type;
    private string    $src;
    private string    $title;
    private string    $description;
    private ?array    $tags;
    private string    $visibility;
    private ?array    $reactions;
    private \DateTime $createdAt;
    private ?string   $socialLinkSource;
    private ?string   $serviceId;
    private array     $additionalInfo;
    private string    $teamId;
    private string    $createdBy;
    private ?string   $gameId;
    private bool      $isPublic;
    private ?string   $srcThumbnail;
    private string    $channelId;
    private string    $groupId;
    private string    $replyCount;
    
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    
    /**
     * @param int $id
     * @return Media
     */
    public function setId(int $id): Media
    {
        $this->id = $id;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
    
    /**
     * @param string $type
     * @return Media
     */
    public function setType(string $type): Media
    {
        $this->type = $type;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getSrc(): string
    {
        return $this->src;
    }
    
    /**
     * @param string $src
     * @return Media
     */
    public function setSrc(string $src): Media
    {
        $this->src = $src;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }
    
    /**
     * @param string $title
     * @return Media
     */
    public function setTitle(string $title): Media
    {
        $this->title = $title;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
    
    /**
     * @param string $description
     * @return Media
     */
    public function setDescription(string $description): Media
    {
        $this->description = $description;
        return $this;
    }
    
    /**
     * @return array|null
     */
    public function getTags(): ?array
    {
        return $this->tags;
    }
    
    /**
     * @param array|null $tags
     * @return Media
     */
    public function setTags($tags): Media
    {
        $this->tags = empty($tags) ? [] : $tags;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getVisibility(): string
    {
        return $this->visibility;
    }
    
    /**
     * @param string $visibility
     * @return Media
     */
    public function setVisibility(string $visibility): Media
    {
        $this->visibility = $visibility;
        return $this;
    }
    
    /**
     * @return array|null
     */
    public function getReactions(): ?array
    {
        return $this->reactions;
    }
    
    /**
     * @param array|null $reactions
     * @return Media
     */
    public function setReactions(?array $reactions): Media
    {
        $this->reactions = $reactions;
        return $this;
    }
    
    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }
    
    /**
     * @param \DateTime|string $createdAt
     * @return Media
     */
    public function setCreatedAt($createdAt): Media
    {
        if (is_string($createdAt)) {
            $createdAt = new \DateTime($createdAt);
        }
        $this->createdAt = $createdAt;
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getSocialLinkSource(): ?string
    {
        return $this->socialLinkSource;
    }
    
    /**
     * @param string|null $socialLinkSource
     * @return Media
     */
    public function setSocialLinkSource(?string $socialLinkSource): Media
    {
        $this->socialLinkSource = $socialLinkSource;
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getServiceId(): ?string
    {
        return $this->serviceId;
    }
    
    /**
     * @param string|null $serviceId
     * @return Media
     */
    public function setServiceId(?string $serviceId): Media
    {
        $this->serviceId = $serviceId;
        return $this;
    }
    
    /**
     * @return array
     */
    public function getAdditionalInfo(): array
    {
        return $this->additionalInfo;
    }
    
    /**
     * @param array $additionalInfo
     * @return Media
     */
    public function setAdditionalInfo(array $additionalInfo): Media
    {
        $this->additionalInfo = $additionalInfo;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getTeamId(): string
    {
        return $this->teamId;
    }
    
    /**
     * @param string $teamId
     * @return Media
     */
    public function setTeamId(string $teamId): Media
    {
        $this->teamId = $teamId;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }
    
    /**
     * @param string $createdBy
     * @return Media
     */
    public function setCreatedBy(string $createdBy): Media
    {
        $this->createdBy = $createdBy;
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getGameId(): ?string
    {
        return $this->gameId;
    }
    
    /**
     * @param string|null $gameId
     * @return Media
     */
    public function setGameId(?string $gameId): Media
    {
        $this->gameId = $gameId;
        return $this;
    }
    
    /**
     * @return bool
     */
    public function isPublic(): bool
    {
        return $this->isPublic;
    }
    
    /**
     * @param bool $isPublic
     * @return Media
     */
    public function setIsPublic(bool $isPublic): Media
    {
        $this->isPublic = $isPublic;
        return $this;
    }
    
    /**
     * @return string|null
     */
    public function getSrcThumbnail(): ?string
    {
        return $this->srcThumbnail;
    }
    
    /**
     * @param string|null $srcThumbnail
     * @return Media
     */
    public function setSrcThumbnail(?string $srcThumbnail): Media
    {
        $this->srcThumbnail = $srcThumbnail;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getChannelId(): string
    {
        return $this->channelId;
    }
    
    /**
     * @param string $channelId
     * @return Media
     */
    public function setChannelId(string $channelId): Media
    {
        $this->channelId = $channelId;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getGroupId(): string
    {
        return $this->groupId;
    }
    
    /**
     * @param string $groupId
     * @return Media
     */
    public function setGroupId(string $groupId): Media
    {
        $this->groupId = $groupId;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getReplyCount(): string
    {
        return $this->replyCount;
    }
    
    /**
     * @param string $replyCount
     * @return Media
     */
    public function setReplyCount(string $replyCount): Media
    {
        $this->replyCount = $replyCount;
        return $this;
    }
}