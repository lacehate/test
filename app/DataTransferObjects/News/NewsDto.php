<?php

namespace App\DataTransferObjects\News;

final class NewsDto
{
    /**
     * @var string
     */
    private string $title;

    /**
     * @var string
     */
    private string $slug;

    /**
     * @var int
     */
    private int $news_category_id;

    /**
     * @var string
     */
    private string $content;

    /**
     * @var string
     */
    private string $preview;

    /**
     * @var string
     */
    private ?string $published_at;

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @return int
     */
    public function getNewsCategoryId(): int
    {
        return $this->news_category_id;
    }
    /**
     * @return string
     */
    public function getPreview(): string
    {
        return $this->preview;
    }
    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
    /**
     * @return string|null
     */
    public function getPublishedAt(): ?string
    {
        return $this->published_at;
    }


    /**
     * @param string $title
     * @param string $slug
     * @param int $news_category_id
     * @param string $preview
     * @param string $content
     */
    public function __construct(
        string $title,
        string $slug,
        int $news_category_id,
        string $preview,
        string $content,
        ?string $published_at,
    )
    {
        $this->title = $title;
        $this->slug = $slug;
        $this->news_category_id = $news_category_id;
        $this->preview = $preview;
        $this->content = $content;
        $this->published_at = $published_at;
    }
}
