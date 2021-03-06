<?php
namespace Braindigit\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * User
 */
class User extends BaseUser
{
    protected $fullname;
    protected $profile_picture;
    protected $updatedOn;
    protected $registeredOn;
    protected $remove_profile_picture;
    protected $old_profile_picture;
    private $profile_picture_file;
    private $temporary_file;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    public function getFullname()
    {
        return $this->fullname;
    }

    public function setFullname($fullname)
    {
        $this->fullname = $fullname;
    }

    public function setUpdatedOn($updatedOn)
    {
        $this->updatedOn = $updatedOn;
    }

    public function getUpdatedOn()
    {
        return $this->updatedOn;
    }

    /**
     * Set profile_picture
     *
     * @param string $profilePicture
     * @return User
     */
    public function setProfilePicture($profilePicture)
    {
        $this->profile_picture = $profilePicture;

        return $this;
    }

    /**
     * Get profile_picture
     *
     * @return string
     */
    public function getProfilePicture()
    {
        return $this->profile_picture;
    }

    /**
     * Get absolute path of profile_picture
     *
     * @return null|string
     */
    public function getAbsoluteProfilePicture()
    {
        return null === $this->profile_picture
            ? null
            : $this->getUploadRootDir().'/'.$this->profile_picture;
    }

    /**
     * Get web compatible path of profile picture
     *
     * @return null|string
     */
    public function getWebProfilePicture()
    {
        return null === $this->profile_picture
            ? null
            : $this->getUploadDir().'/'.$this->profile_picture;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return '/uploads/profile_pictures';
    }

    public function setProfilePictureFile(UploadedFile $file = null)
    {
        $this->profile_picture_file = $file;
        $this->updatedOn = new \DateTime();
        // check if we have an old image path
        if (isset($this->profile_picture)) {
            // store the old name to delete after the update
            if(!empty($this->profile_picture)) {
                $this->old_profile_picture = $this->getWebProfilePicture();
            }
            $this->temporary_file = $this->profile_picture;
            $this->profile_picture = null;
        } else {
            $this->profile_picture = 'initial';
        }
    }

    public function getProfilePictureFile()
    {
        return $this->profile_picture_file;
    }

    public function preUpload()
    {
        if (null !== $this->getProfilePictureFile()) {
            // do whatever you want to generate a unique name
            $filename = sha1(uniqid(mt_rand(), true));
            $this->profile_picture = $filename.'.'.$this->getProfilePictureFile()->guessExtension();
        } else {
            //check if user wants to remove current profile picture
            $current_pp = $this->getAbsoluteProfilePicture();
            if(!empty($this->remove_profile_picture) && !empty($current_pp)) {
                //save in old profile picture for cacheimage listener
                $this->old_profile_picture = $this->getWebProfilePicture();
                $this->profile_picture = null;
                if(is_file($current_pp))
                    unlink($current_pp);
            }
        }
    }

    public function upload()
    {
        if (null === $this->getProfilePictureFile()) {
            return;
        }

        // if there is an error when moving the file, an exception will
        // be automatically thrown by move(). This will properly prevent
        // the entity from being persisted to the database on error
        $this->getProfilePictureFile()->move($this->getUploadRootDir(), $this->profile_picture);

        // check if we have an old image
        if (isset($this->temporary_file)) {
            // delete the old image
            unlink($this->getUploadRootDir().'/'.$this->temporary_file);
            // clear the temp image path
            $this->temporary_file = null;
        }
        $this->profile_picture_file = null;
    }

    public function removeUpload()
    {
        $file = $this->getAbsoluteProfilePicture();
        if ($file) {
            unlink($file);
        }
    }

    public function getRemoveProfilePicture()
    {
        return $this->remove_profile_picture;
    }

    public function setRemoveProfilePicture($remove_profile_picture)
    {
        if(!empty($remove_profile_picture)) {
            $this->updatedOn = new \DateTime();
        }
        $this->remove_profile_picture = $remove_profile_picture;
    }

    public function getOldProfilePicture()
    {
        return $this->old_profile_picture;
    }

    public function getDefaultProfilePicture()
    {
        return null === $this->profile_picture
            ? '/bundles/braindigitcommon/images/userprofile.jpg'
            : $this->getUploadDir().'/'.$this->profile_picture;
    }

    public function getRegisteredOn()
    {
        return $this->registeredOn;
    }

    public function setRegisteredOnValue()
    {
        $this->registeredOn = new \DateTime();
    }
}