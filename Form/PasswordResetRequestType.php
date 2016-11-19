<?php

namespace inem0o\UserPasswordLostBundle\Form;

use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Validator\Constraints\CallbackValidator;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints\Email as AssertEmail;

class PasswordResetRequestType extends AbstractType
{

    /** @var Translator */
    private $translator;
    /** @var array */
    private $formConfig;

    public function __construct(Translator $translator, $formConfig)
    {
        $this->translator = $translator;
        $this->formConfig = $formConfig;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $fieldConstraints = [];
        foreach ($this->formConfig['constraints'] as $constraint) {
            if ($constraint['form_name'] == 'form_password_request') {
                $fieldConstraints[$constraint['field']][] = new $constraint['class']($constraint['params']);
            }
        }

        $builder
            ->add(
                'user_email',
                EmailType::class,
                [
                    'label'       => $this->translator->trans('user_password_lost_bundle.form.label.email', [], 'userPasswordLostBundle'),
                    'constraints' => $fieldConstraints['user_email'] ?? null,
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'inem0o\UserPasswordLostBundle\Entity\PasswordResetRequest',
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'UserPasswordLostBundle_PasswordResetRequest';
    }
}
