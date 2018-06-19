<?php

namespace AppBundle\FormModel;

use Symfony\Component\Validator\Constraints as Assert;

class Offer
{
    /**
     * @Assert\NotBlank(message="Title should not be blank")
     * @Assert\Length(min="1", max="255")
     * @var string
     */
    public $title;

    /**
     * @Assert\NotBlank(message="Description should not be blank")
     * @var string
     */
    public $description;

    /**
     * @Assert\NotBlank(message="Email should not be blank")
     * @Assert\Email(
     *     message = "The email {{ value }} is not a valid email."
     * )
     * @var string
     */
    public $email;

    /**
     * @Assert\NotBlank(message="Image URL should not be blank")
     * @var string
     */
    public $image_url;

    /**
     * Set all the field from an array
     * @param $data
     */
    public function setData(array $data)
    {
        foreach ($data as $key => $value) {
            if(!property_exists($this,$key)) {
                continue;
            }
            $this->$key = $value;
        }
    }
}