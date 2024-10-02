<?php

namespace App\Entity;

use App\Enum\CommentStatusEnum;
use App\Repository\CommentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: CommentStatusEnum::class)]
    private ?CommentStatusEnum $Status = null;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'childComments')]
    private ?self $parentComment = null;

    /**
     * @var Collection<int, self>
     */
    #[ORM\OneToMany(targetEntity: self::class, mappedBy: 'parentComment')]
    private Collection $childComments;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?user $publisher = null;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    private ?Media $media = null;

    #[ORM\ManyToOne(inversedBy: 'commentsUser')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function __construct()
    {
        $this->childComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?CommentStatusEnum
    {
        return $this->Status;
    }

    public function setStatus(CommentStatusEnum $Status): static
    {
        $this->Status = $Status;

        return $this;
    }

    public function getParentComment(): ?self
    {
        return $this->parentComment;
    }

    public function setParentComment(?self $parentComment): static
    {
        $this->parentComment = $parentComment;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getChildComments(): Collection
    {
        return $this->childComments;
    }

    public function addChildComment(self $childComment): static
    {
        if (!$this->childComments->contains($childComment)) {
            $this->childComments->add($childComment);
            $childComment->setParentComment($this);
        }

        return $this;
    }

    public function removeChildComment(self $childComment): static
    {
        if ($this->childComments->removeElement($childComment)) {
            // set the owning side to null (unless already changed)
            if ($childComment->getParentComment() === $this) {
                $childComment->setParentComment(null);
            }
        }

        return $this;
    }

    public function getPublisher(): ?user
    {
        return $this->publisher;
    }

    public function setPublisher(?user $publisher): static
    {
        $this->publisher = $publisher;

        return $this;
    }

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): static
    {
        $this->media = $media;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
