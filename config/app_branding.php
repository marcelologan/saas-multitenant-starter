<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Informações da Aplicação
    |--------------------------------------------------------------------------
    |
    | Configurações básicas da marca e aplicação que serão utilizadas
    | em toda a interface, emails, documentos e comunicações.
    |
    */

    'app' => [
        'name' => 'Fashion Manager',
        'tagline' => 'Gestão Têxtil',
        'description' => 'Gestão Têxtil Inteligente',
        'description_long' => 'Sistema completo para gestão de produção, controle de qualidade e otimização de processos na indústria do vestuário',
        'industry' => 'Têxtil',
        'industry_adjective' => 'têxtil',
        'business_type' => 'confecção',
        'business_type_plural' => 'confecções',
        'product_unit' => 'peças',
        'product_unit_singular' => 'peça',
        'segment' => 'vestuário',
    ],

    /*
    |--------------------------------------------------------------------------
    | Logos e Imagens
    |--------------------------------------------------------------------------
    |
    | Caminhos para logos, ícones e imagens da marca em diferentes contextos.
    |
    */

    'logos' => [
        'icon' => 'assets/img/fm_ico.png',
        'full' => 'assets/img/fm_logo.png',
        'favicon' => 'favicon.ico',
        'alt' => 'Fashion Manager',
        'sizes' => [
            'navbar' => 'w-8 h-8',
            'navbar_full' => 'h-16',
            'login' => 'h-12',
            'login_desktop' => 'h-16',
            'footer' => 'w-10 h-10',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Meta Tags e SEO
    |--------------------------------------------------------------------------
    |
    | Informações para otimização de mecanismos de busca e meta tags.
    |
    */

    'meta' => [
        'title' => 'Fashion Manager - Gestão Inteligente para Indústria Têxtil',
        'title_short' => 'Fashion Manager',
        'description' => 'Sistema completo para gestão de produção, controle de qualidade e otimização de processos na indústria do vestuário',
        'keywords' => 'gestão, têxtil, fashion, produção, confecção, indústria, vestuário, controle qualidade',
        'author' => 'Fashion Manager',
        'robots' => 'index, follow',
    ],

    /*
    |--------------------------------------------------------------------------
    | Textos do Hero/Landing
    |--------------------------------------------------------------------------
    |
    | Textos principais da página inicial e landing pages.
    |
    */

    'hero' => [
        'title' => 'Revolucione sua Produção Têxtil',
        'title_highlight' => 'Produção Têxtil',
        'subtitle' => 'Sistema completo para gestão de produção, controle de qualidade e otimização de processos na indústria do vestuário',
        'cta_primary' => 'Teste Grátis por 30 Dias',
        'cta_secondary' => 'Ver Demonstração',
        'trust_message' => 'Mais de 500 empresas já confiam no Fashion Manager',
    ],

    /*
    |--------------------------------------------------------------------------
    | Estatísticas
    |--------------------------------------------------------------------------
    |
    | Números e estatísticas exibidos na landing page.
    |
    */

    'stats' => [
        [
            'number' => '500+',
            'label' => 'Empresas Atendidas',
        ],
        [
            'number' => '2M+',
            'label' => 'Peças Produzidas',
        ],
        [
            'number' => '35%',
            'label' => 'Aumento Eficiência',
        ],
        [
            'number' => '99.9%',
            'label' => 'Uptime Sistema',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Seções da Landing
    |--------------------------------------------------------------------------
    |
    | Títulos e textos das principais seções da landing page.
    |
    */

    'sections' => [
        'features' => [
            'title' => 'Funcionalidades Específicas para Indústria Têxtil',
            'title_highlight' => 'Indústria Têxtil',
            'subtitle' => 'Desenvolvido especificamente para as necessidades da produção de vestuário',
        ],
        'pricing' => [
            'title' => 'Planos que Crescem com seu Negócio',
            'title_highlight' => 'Negócio',
            'subtitle' => 'Escolha o plano ideal para o tamanho da sua operação',
        ],
        'cta' => [
            'title' => 'Pronto para Revolucionar sua Produção?',
            'subtitle' => 'Junte-se a centenas de empresas que já otimizaram seus processos',
            'button' => 'Começar Teste Grátis Agora',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Planos e Preços
    |--------------------------------------------------------------------------
    |
    | Configurações dos planos de assinatura.
    |
    */

    'plans' => [
        'starter' => [
            'name' => 'Starter',
            'description' => 'Ideal para pequenas confecções',
            'price' => '0.00',
            'period' => '30 dias grátis',
            'cta' => 'Começar Grátis',
        ],
        'professional' => [
            'name' => 'Professional',
            'description' => 'Para empresas em crescimento',
            'price' => '149.90',
            'period' => 'mês',
            'cta' => 'Mais Popular',
        ],
        'business' => [
            'name' => 'Business',
            'description' => 'Para médias empresas',
            'price' => '299.90',
            'period' => 'mês',
            'cta' => 'Escolher Plano',
        ],
        'enterprise' => [
            'name' => 'Enterprise',
            'description' => 'Solução completa',
            'price' => 'Personalizado',
            'period' => '',
            'cta' => 'Falar com Vendas',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Placeholders de Formulários
    |--------------------------------------------------------------------------
    |
    | Textos de exemplo para campos de formulários.
    |
    */

    'placeholders' => [
        'company_name' => 'Confecções Exemplo LTDA',
        'trade_name' => 'Confecções Exemplo',
        'admin_name' => 'João Silva',
        'admin_email' => 'joao@confeccoes.com',
        'login_email' => 'seu@email.com',
        'phone' => '(11) 99999-9999',
        'cnpj' => '00.000.000/0000-00',
        'address' => 'Rua das Confecções, 123 - Centro - São Paulo/SP',
        'password' => 'Mínimo 8 caracteres',
        'password_confirm' => 'Digite a senha novamente',
    ],

    /*
    |--------------------------------------------------------------------------
    | Textos de Call-to-Action
    |--------------------------------------------------------------------------
    |
    | Textos dos botões e links de ação.
    |
    */

    'cta' => [
        'register' => 'Criar Conta Gratuita',
        'register_free' => 'Começar Grátis',
        'login' => 'Entrar',
        'signup_link' => 'Cadastre-se gratuitamente',
        'login_link' => 'Fazer login',
        'free_trial' => 'Teste Grátis por 30 Dias',
        'demo' => 'Ver Demonstração',
        'contact_sales' => 'Falar com Vendas',
        'get_started' => 'Começar Agora',
        'learn_more' => 'Saiba Mais',
    ],

    /*
    |--------------------------------------------------------------------------
    | Depoimento/Testimonial
    |--------------------------------------------------------------------------
    |
    | Depoimento de cliente para a página de login.
    |
    */

    'testimonial' => [
        'name' => 'Maria Rodrigues',
        'position' => 'CEO',
        'company' => 'Confecções Bella',
        'initials' => 'MR',
        'quote' => 'O Fashion Manager revolucionou nossa produção. Aumentamos 40% nossa eficiência em apenas 3 meses.',
        'efficiency_increase' => '40%',
        'timeframe' => '3 meses',
    ],

    /*
    |--------------------------------------------------------------------------
    | Textos da Autenticação
    |--------------------------------------------------------------------------
    |
    | Textos específicos das páginas de login e registro.
    |
    */

    'auth' => [
        'login' => [
            'title' => 'Entrar na sua conta',
            'subtitle' => 'Não tem uma conta?',
            'welcome_back' => 'Bem-vindo de volta!',
            'welcome_subtitle' => 'Acesse sua conta e continue gerenciando sua produção têxtil com eficiência.',
            'remember_me' => 'Lembrar-me',
            'forgot_password' => 'Esqueceu a senha?',
            'or_continue' => 'Ou continue com',
            'security_notice' => 'Seus dados estão protegidos com criptografia SSL',
        ],
        'register' => [
            'title' => 'Crie sua conta gratuita',
            'subtitle' => 'Comece a revolucionar sua produção do vestuário hoje mesmo',
            'already_have_account' => 'Já tem uma conta?',
            'company_section' => [
                'title' => 'Dados da Confecção',
                'subtitle' => 'Informações básicas da sua confecção',
            ],
            'admin_section' => [
                'title' => 'Administrador Principal',
                'subtitle' => 'Dados do responsável pela conta',
            ],
            'plan_section' => [
                'title' => 'Escolha seu Plano',
                'subtitle' => 'Comece com 30 dias grátis em qualquer plano',
            ],
            'trust_message' => '🔒 Seus dados estão seguros e protegidos',
            'terms_text' => 'Eu concordo com os',
            'terms_link' => 'Termos de Uso',
            'privacy_link' => 'Política de Privacidade',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Informações de Contato
    |--------------------------------------------------------------------------
    |
    | Dados de contato da empresa.
    |
    */

    'contact' => [
        'company_name' => 'Fashion Manager Sistemas LTDA',
        'email' => 'contato@fashionmanager.com.br',
        'phone' => '(11) 3000-0000',
        'whatsapp' => '(11) 99000-0000',
        'address' => 'Rua da Tecnologia, 123 - São Paulo/SP',
        'support_email' => 'suporte@fashionmanager.com.br',
        'sales_email' => 'vendas@fashionmanager.com.br',
    ],

    /*
    |--------------------------------------------------------------------------
    | Redes Sociais
    |--------------------------------------------------------------------------
    |
    | Links para redes sociais da empresa.
    |
    */

    'social' => [
        'facebook' => 'https://facebook.com/fashionmanager',
        'instagram' => 'https://instagram.com/fashionmanager',
        'linkedin' => 'https://linkedin.com/company/fashionmanager',
        'youtube' => 'https://youtube.com/fashionmanager',
        'twitter' => 'https://twitter.com/fashionmanager',
    ],

    /*
    |--------------------------------------------------------------------------
    | Configurações de Email
    |--------------------------------------------------------------------------
    |
    | Configurações para emails transacionais.
    |
    */

    'email' => [
        'from_name' => 'Fashion Manager',
        'from_email' => 'noreply@fashionmanager.com.br',
        'signature' => 'Equipe Fashion Manager',
        'footer_text' => 'Fashion Manager - Gestão Têxtil Inteligente',
        'logo' => 'assets/img/fm_logo.png',
    ],

    /*
    |--------------------------------------------------------------------------
    | PWA (Progressive Web App)
    |--------------------------------------------------------------------------
    |
    | Configurações para aplicativo web progressivo.
    |
    */

    'pwa' => [
        'name' => 'Fashion Manager',
        'short_name' => 'FashionMgr',
        'description' => 'Gestão Têxtil Inteligente',
        'theme_color' => '#6366f1',
        'background_color' => '#ffffff',
        'display' => 'standalone',
        'start_url' => '/',
        'icons' => [
            '192' => 'assets/img/icon-192.png',
            '512' => 'assets/img/icon-512.png',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Configurações do Footer
    |--------------------------------------------------------------------------
    |
    | Textos e links do rodapé.
    |
    */

    'footer' => [
        'description' => 'Transformamos a gestão de produção têxtil com tecnologia de ponta e foco na eficiência operacional.',
        'copyright' => 'Todos os direitos reservados.',
        'links' => [
            'product' => [
                'title' => 'Produto',
                'items' => [
                    'Funcionalidades' => '#features',
                    'Preços' => '#pricing',
                    'Integrações' => '#',
                    'API' => '#',
                ],
            ],
            'support' => [
                'title' => 'Suporte',
                'items' => [
                    'Central de Ajuda' => '#',
                    'Documentação' => '#',
                    'Contato' => '#contact',
                    'Status' => '#',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Clientes/Trust Signals
    |--------------------------------------------------------------------------
    |
    | Logos de clientes para exibir como prova social.
    |
    */

    'clients' => [
        [
            'name' => 'Cliente 1',
            'logo' => null, // Placeholder
        ],
        [
            'name' => 'Cliente 2',
            'logo' => null, // Placeholder
        ],
        [
            'name' => 'Cliente 3',
            'logo' => null, // Placeholder
        ],
        [
            'name' => 'Cliente 4',
            'logo' => null, // Placeholder
        ],
    ],
];