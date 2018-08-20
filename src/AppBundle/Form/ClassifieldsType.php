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
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class ClassifieldsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("title", TextType::class, ["label" => "Nazwa", "constraints" => [
                new NotBlank(['message' => 'Tytuł nie może być pusty.']),
                new Length(['min' => 3, 'minMessage' => 'Tytuł nie może być krótszy niż 3 znaki.',
                    'max' => '255', 'maxMessage' => 'Tytuł nie może być dłuższy niż 255 znaków.'])
            ]])
            ->add("description", TextareaType::class, ["label" => "Opis", "constraints" => [
                new NotBlank(['message' => 'Opis nie może być pusty.']),
                new Length(['min' => 10, 'minMessage' => 'Opis nie może być krótszy niż 10 znaków'])
            ]])
            ->add("contact", TextType::class,["label" => "Adres e-mail", "constraints" => [
                new NotBlank(['message' => 'E-mail nie może być pusty.']),
                new Email(['message' => 'Wartośc nie jest adresem e-mail.'])
            ]])
            ->add("indicator", ChoiceType::class, ["label" => "Wybór kategorii",
                "choices" => ["Sprzedam" => "sprzedam", "Kupię" => "kupie", "Zamienię" => "zamienie"]])
            ->add("expiresAt", DateTimeType::class, ["label" => "Data zakończenia", "data" => new \DateTime("+7 day + 10 minutes")])
            ->add("price", NumberType::class, ["label" => "Cena / Wartość", "constraints" => [
                new  NotBlank(['message' => 'Cena nie może być pusta.']),
                new GreaterThan(['value' => 0, 'message' => 'Cena musi być większa od 0.'])
            ]])
            ->add("image", FileType::class, [
                "data_class" => null, "label" => "Plik (.png, .jpg, .jpeg)", "constraints" => [
                    new Image(['mimeTypes' => 'image/png", "image/jpg", "image/jpeg',
                        'mimeTypesMessage' => 'Tylko rozszerzenie png, jpg. jpeg.',
                        'minWidth' => 150,
                        'minWidthMessage' => 'Minimalny dopuszczalny rozmiar szerokości zdjęcia to 150px.',
                        'maxWidth' => 1000,
                        'maxWidthMessage' => 'Maksymalny dopuszczalny rozmiar szerokości zdjęcia to 1000px.',
                        'minHeight' => 150,
                        'minHeightMessage' => 'Minimalny dopuszczalny rozmiar wysokości zdjęcia to 150px.',
                        'maxHeight' => 1000,
                        'maxHeightMessage' => 'Maksymalny dopuszczalny rozmiar wysokości zdjęcia to 1000px.'
                        ])
                ]])
            ->add("submit", SubmitType::class, ["label" => "Dodaj ogłoszenie"])
            ->getForm();

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(["data_class" => Classifields::class]);
    }
}
//"data_class" => null,