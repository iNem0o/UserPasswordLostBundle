<?php

namespace inem0o\UserPasswordLostBundle\Form;

use Symfony\Component\Translation\Translator;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank as AssertNotBlank;

class NewPasswordType extends AbstractType
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
            if ($constraint['form_name'] == 'form_new_password') {
                $fieldConstraints[$constraint['field']][] = new $constraint['class']($constraint['params']);
            }
        }

        $builder
            ->add(
                'plainPassword',
                RepeatedType::class,
                [
                    'type'            => PasswordType::class,
                    'invalid_message' => $this->translator->trans('user_password_lost_bundle.form_validation.password.mismatch', [], 'userPasswordLostBundle'),
                    'first_options'   => array('label' => $this->translator->trans('user_password_lost_bundle.form.label.new_password', [], 'userPasswordLostBundle')),
                    'second_options'  => array('label' => $this->translator->trans('user_password_lost_bundle.form.label.password_confirmation', [], 'userPasswordLostBundle')),
                    'required'        => true,
                    'constraints'     => $fieldConstraints['plainPassword'] ?? null,
                ]
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array()
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'UserPasswordLostBundle_NewPassword';
    }
}
