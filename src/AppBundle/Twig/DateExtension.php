<?php
/**
 * Created by PhpStorm.
 * User: kamilbereda
 * Date: 08.06.2018
 * Time: 17:45
 */

namespace AppBundle\Twig;


class DateExtension extends \Twig_Extension
{
    /**
     * @return array|\Twig_SimpleFilter[]
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter("expireDate", [$this, "expireDate"])
        ];
    }

    /**
     * @return array|\Twig_SimpleFunction[]
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction("classifieldsStyle", [$this, "classifieldsStyle"]),
            new \Twig_SimpleFunction("classifieldsExpire", [$this, "classifieldsExpire"])
        ];
    }

    /**
     * @param \DateTime $expiresAt
     * @return string
     */
    public function expireDate(\DateTime $expiresAt)
    {
        if ($expiresAt > new \DateTime("7 days")) {
            return $expiresAt->format("Y-m-d");
        }

        elseif ($expiresAt > new \DateTime("1 day") && $expiresAt < new \DateTime("7 days")) {
            return "za " . $expiresAt->diff(new \DateTime())->days . " dni";
        }

        elseif ($expiresAt > new \DateTime("now") && $expiresAt <= new \DateTime("24 hours")) {
            return "za " . $expiresAt->diff(new \DateTime("now"))->format("%h") . " godz. " . " i " .
                $expiresAt->diff(new \DateTime("now"))->format("%i") . " min." ;
        }

        elseif ($expiresAt < new \DateTime("now")) {
            return "";
        }

        else {
            return $expiresAt->format("Y-m-d H:i");
        }
    }

    /**
     * @param \DateTime $expiresAt
     * @return string
     */
    public function classifieldsStyle(\DateTime $expiresAt)
    {
        if ($expiresAt > new \DateTime("now") && $expiresAt < new \DateTime("1 day")) {
            return "panel-warning";
        }
        elseif ($expiresAt > new \DateTime("1 day")) {
            return "panel-success";
        }

        elseif ($expiresAt < new \DateTime("now")) {
            return "panel-danger";
        }
        else {
            return "panel-default";
        }

    }

    /**
     * @param \DateTime $expiresAt
     * @return string
     */
    public function classifieldsExpire(\DateTime $expiresAt)
    {
        if($expiresAt < new \DateTime("now")) {
            return "Ogłoszenie zakończone.";
        }
        else {
            return "Ogłoszenie kończy się ";
        }

    }
}