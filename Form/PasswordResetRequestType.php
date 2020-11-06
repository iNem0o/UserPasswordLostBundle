<?php

namespace inem0o\UserPasswordLostBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Contracts\Translation\TranslatorInterface;
use inem0o\UserPasswordLostBundle\Entity\PasswordResetRequest;

class PasswordResetRequestType extends AbstractType
{

    /** @var TranslatorInterface */
    private $translator;
    /** @var array */
    private $formConfig;

    public function __construct(TranslatorInterface $translator, $formConfig)
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
            if ($constraint['form_name'] === 'form_password_request') {
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
            [
                'data_class' => PasswordResetRequest::class,
            ]
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
