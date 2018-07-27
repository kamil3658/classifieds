<?php
/**
 * Created by PhpStorm.
 * User: kamilbereda
 * Date: 05.07.2018
 * Time: 17:30
 */

namespace AppBundle\Form;


use AppBundle\Entity\Classifields;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClassifieldsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("title", TextType::class, ["label" => "Nazwa"])
            ->add("description", TextareaType::class, ["label" => "Opis"])
            ->add("contact", TextType::class,["label" => "Adres e-mail"])
            ->add("indicator", ChoiceType::class, ["label" => "Wybór kategorii",
                "choices" => ["Sprzedam" => "sprzedam", "Kupię" => "kupie", "Zamienię" => "zamienie"]])
            ->add("expiresAt", DateTimeType::class, ["label" => "Data zakończenia", "data" => new \DateTime("+7 day + 10 minutes")])
            ->add("price", NumberType::class, ["label" => "Cena / Wartość"])
            ->add("image", FileType::class, ["data_class" => null, "label" => "Plik (.png, .jpg, .jpeg)"])
            ->add("submit", SubmitType::class, ["label" => "Dodaj ogłoszenie"])
            ->getForm();

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(["data_class" => Classifields::class]);
    }
}
//"data_class" => null,