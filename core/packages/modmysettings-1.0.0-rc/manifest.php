<?php return array (
  'manifest-version' => '1.1',
  'manifest-attributes' => 
  array (
    'changelog' => 'Changelog for modMySettings.

1.0.0 pl
==============
Добавление и настройка технических страниц
- search
- Ошибка 404
- Достпуп запрещен
- Сайт временно недоступен
- sitemap и сниппет pdositemap
- robots

Добавление чанков
- gbl.body-end
- gbl.body-start
- gbl.footer
- gbl.head
- gbl.sidebar

Добавление шаблонов
- service для технических страниц
- page общий

Добавление приложений
- pdoTools
- MinifyX
- modDevTools
- Console
- translit

1.0.0 pl
==============
Завести администратора iadmin и установить пароль


',
    'license' => 'Changelog for miniShop2.

1.0.0 pl
==============
Добавление и настройка технических страниц
- search
- Ошибка 404
- Достпуп запрещен
- Сайт временно недоступен
- sitemap и сниппет pdositemap
- robots

Добавление чанков
- gbl.body-end
- gbl.body-start
- gbl.footer
- gbl.head
- gbl.sidebar

Добавление шаблонов
- service для технических страниц
- page общий

Добавление приложений
- pdoTools
- MinifyX
- modDevTools
- Console
- translit



',
    'readme' => 'Changelog for miniShop2.

1.0.0 pl
==============
Добавление и настройка технических страниц
- search
- Ошибка 404
- Достпуп запрещен
- Сайт временно недоступен
- sitemap и сниппет pdositemap
- robots

Добавление чанков
- gbl.body-end
- gbl.body-start
- gbl.footer
- gbl.head
- gbl.sidebar

Добавление шаблонов
- service для технических страниц
- page общий

Добавление приложений
- pdoTools
- MinifyX
- modDevTools
- Console
- translit



',
    'js' => '
function thisTab(thisa){

    var el = Ext.get(thisa)
    var id = el.id;

    Ext.get( "con-ms-page-tab").addClass("x-hide-display");
    Ext.get( "con-ms-pack-tab").addClass("x-hide-display");
    Ext.get( "con-ms-settings-tab").addClass("x-hide-display");

    Ext.get( "ms-page-tab").parent().removeClass("x-tab-strip-active");
    Ext.get( "ms-pack-tab").parent().removeClass("x-tab-strip-active");
    Ext.get( "ms-settings-tab").parent().removeClass("x-tab-strip-active");
    var el_action = Ext.get("con-"+id);
    el.parent().addClass("x-tab-strip-active");
    el_action.removeClass("x-hide-display");

}
function thisPlus(thisa){

    var el = Ext.get(thisa);
    var id = el.id;
    var parent = Ext.get(\'settings_\'+id+\'\');
    var desc = Ext.get(\'desc_\'+id+\'\');

    console.log(desc);
    if(parent.dom.className == \'x-grid3-row-collapsed\'){
        parent.dom.className = \'x-grid3-row-expanded\';
        Ext.get(\'desc_\'+id+\'\').removeClass("msettings-hidden");
    } else {
        parent.dom.className = \'x-grid3-row-collapsed\';
        Ext.get(\'desc_\'+id+\'\').addClass("msettings-hidden");
    }
    /*
    Ext.get( "con-ms-page-tab").addClass("x-hide-display");

    Ext.get( "ms-pack-tab").parent().removeClass("x-grid3-row-collapsed");
    Ext.get( "ms-settings-tab").parent().removeClass("x-tab-strip-active");

    var el_action = Ext.get("con-"+id);
    el.parent().addClass("x-grid3-row-expanded");*/

}





',
    'resources' => 
    array (
      'system' => 
      array (
        'pagetitle' => 'system',
        'checked' => 1,
        'blocked' => 1,
        'desc' => 'Основной контенер для служебных страниц',
        'template' => 0,
        'published' => 0,
        'hidemenu' => 1,
        'cacheable' => 0,
        'parent' => 0,
        'alias' => 'system',
        'content_type' => 1,
        'richtext' => 0,
        'searchable' => 0,
        'content' => '',
        'uri_override' => 1,
        'uri' => 'system/',
      ),
      'service' => 
      array (
        'pagetitle' => 'service',
        'checked' => 1,
        'blocked' => 1,
        'desc' => 'контенер для страниц 403,404,503,sitemap,robots.txt',
        'template' => 0,
        'published' => 0,
        'hidemenu' => 1,
        'cacheable' => 0,
        'parent_uri' => 'system/',
        'alias' => 'service',
        'content_type' => 1,
        'richtext' => 0,
        'searchable' => 0,
        'content' => '',
        'uri_override' => 1,
        'uri' => 'service/',
      ),
      'sitemap' => 
      array (
        'pagetitle' => 'sitemap.xml',
        'checked' => 1,
        'desc' => 'формирование карты сайта xml (pdoSitemap)',
        'template' => 0,
        'published' => 1,
        'hidemenu' => 1,
        'parent_uri' => 'service/',
        'alias' => 'sitemap',
        'content_type' => 2,
        'richtext' => 0,
        'searchable' => 0,
        'uri_override' => 1,
        'uri' => 'sitemap.xml',
        'content' => '[[!pdoSitemap? &checkPermissions=`list`]]',
      ),
      'robots' => 
      array (
        'pagetitle' => 'robots.txt',
        'checked' => 1,
        'desc' => 'тоже самое что и robots.txt только ресурсом',
        'template' => 0,
        'published' => 1,
        'hidemenu' => 1,
        'alias' => 'robots',
        'parent_uri' => 'service/',
        'content_type' => 3,
        'richtext' => 0,
        'searchable' => 0,
        'uri_override' => 1,
        'uri' => 'robots.txt',
        'content' => 'User-agent: *
Disallow: /manager/
Disallow: /assets/components/
Allow: /assets/uploads/
Disallow: /core/
Disallow: /connectors/
Disallow: /index.php
Disallow: /search
Disallow: /profile/
Disallow: *? Host: [[++site_url]]
Sitemap: [[++site_url]]sitemap.xml',
      ),
      'error404' => 
      array (
        'pagetitle' => 'Страница не найдена',
        'checked' => 1,
        'desc' => 'страница 404',
        'template' => 0,
        'published' => 1,
        'hidemenu' => 1,
        'alias' => 'error404',
        'content_type' => 1,
        'template_name' => 'service',
        'parent_uri' => 'service/',
        'richtext' => 0,
        'searchable' => 0,
        'uri_override' => 1,
        'uri' => 'error404.html',
        'content' => 'Страница не существует или вы не правильно ввели адрес',
      ),
      'error403' => 
      array (
        'pagetitle' => 'Доступ запрещен',
        'checked' => 1,
        'desc' => 'страница 403',
        'template' => 0,
        'published' => 1,
        'hidemenu' => 1,
        'template_name' => 'service',
        'parent_uri' => 'service/',
        'alias' => 'error403',
        'content_type' => 1,
        'richtext' => 0,
        'searchable' => 0,
        'uri_override' => 1,
        'uri' => 'error403.html',
        'content' => 'Доступ к этой странице запрещен',
      ),
      'error503' => 
      array (
        'pagetitle' => 'Сайт временно не доступен',
        'checked' => 1,
        'desc' => 'страница 503',
        'template' => 0,
        'published' => 1,
        'hidemenu' => 1,
        'template_name' => 'service',
        'parent_uri' => 'service/',
        'alias' => 'error503',
        'content_type' => 1,
        'richtext' => 0,
        'searchable' => 0,
        'uri_override' => 1,
        'uri' => 'error503.html',
        'content' => 'Сайт временно не доступен',
      ),
      'search' => 
      array (
        'pagetitle' => 'Поиск',
        'checked' => 0,
        'desc' => 'страница для поиска по сайту',
        'template' => 0,
        'published' => 1,
        'hidemenu' => 1,
        'alias' => 'search',
        'template_name' => 'page',
        'parent_uri' => 'system/',
        'content_type' => 1,
        'richtext' => 0,
        'searchable' => 0,
        'uri_override' => 1,
        'uri' => 'search.html',
        'content' => '',
      ),
      'cart' => 
      array (
        'pagetitle' => 'Корзина',
        'checked' => 0,
        'desc' => 'страница корзины со снипетами: [[!msCart?]][[!msOrder?]]',
        'template' => 0,
        'published' => 1,
        'hidemenu' => 1,
        'alias' => 'cart',
        'template_name' => 'page',
        'parent_uri' => 'system/',
        'content_type' => 1,
        'richtext' => 0,
        'searchable' => 0,
        'uri_override' => 1,
        'uri' => 'cart.html',
        'content' => '[[!msCart?]][[!msOrder?]]',
      ),
      'cabinet' => 
      array (
        'pagetitle' => 'Личный кабинет',
        'checked' => 0,
        'desc' => 'контенер личного кабинета',
        'template' => 0,
        'published' => 1,
        'hidemenu' => 1,
        'alias' => 'cabinet',
        'template_name' => 'page',
        'parent_uri' => 'system/',
        'content_type' => 1,
        'richtext' => 0,
        'searchable' => 0,
        'uri_override' => 1,
        'uri' => 'cabinet/',
        'content' => '',
      ),
      'auth' => 
      array (
        'pagetitle' => 'Вход на сайт',
        'checked' => 0,
        'desc' => 'страница входа на сайте и сниппетом [[!officeAuth]]',
        'template' => 0,
        'published' => 1,
        'hidemenu' => 1,
        'parent_uri' => 'system/',
        'alias' => 'auth',
        'content_type' => 1,
        'richtext' => 0,
        'searchable' => 0,
        'uri_override' => 1,
        'uri' => 'cabinet/auth.html',
        'content' => '[[!officeAuth]]',
      ),
      'profile' => 
      array (
        'pagetitle' => 'Профиль',
        'checked' => 0,
        'desc' => 'страница с профилем и сниппетом [[!officeProfile`]]',
        'template' => 0,
        'published' => 1,
        'hidemenu' => 1,
        'alias' => 'profile',
        'content_type' => 1,
        'template_name' => 'page',
        'parent_uri' => 'cabinet/',
        'richtext' => 0,
        'searchable' => 0,
        'uri_override' => 1,
        'uri' => 'cabinet/profile.html',
        'content' => '[[!officeProfile`]]',
      ),
      'orders' => 
      array (
        'pagetitle' => 'Мои заказы',
        'checked' => 0,
        'desc' => 'страница с заказами и сниппетом [[!Office?action=`miniShop2`]]',
        'template' => 0,
        'published' => 1,
        'hidemenu' => 1,
        'alias' => 'orders',
        'content_type' => 1,
        'template_name' => 'page',
        'parent_uri' => 'cabinet/',
        'richtext' => 0,
        'searchable' => 0,
        'uri_override' => 1,
        'uri' => 'cabinet/orders.html',
        'content' => '[[!Office?action=`miniShop2`]]',
      ),
      'catalog' => 
      array (
        'pagetitle' => 'Каталог',
        'checked' => 0,
        'desc' => 'страница каталог товаров minishop2 со снипетами: [[!msProducts?]]',
        'template' => 0,
        'published' => 1,
        'hidemenu' => 0,
        'template_name' => 'page',
        'alias' => 'catalog',
        'content_type' => 1,
        'class_key' => 'msCategory',
        'parent' => 0,
        'richtext' => 0,
        'searchable' => 0,
        'uri_override' => 1,
        'uri' => 'catalog.html',
        'content' => '[[!msProducts?]]',
      ),
      'about' => 
      array (
        'pagetitle' => 'О компании',
        'checked' => 0,
        'desc' => '',
        'template' => 0,
        'published' => 1,
        'hidemenu' => 0,
        'alias' => 'about',
        'template_name' => 'page',
        'content_type' => 1,
        'parent' => 0,
        'richtext' => 0,
        'searchable' => 0,
        'uri_override' => 1,
        'uri' => 'about.html',
        'content' => '',
      ),
      'contacts' => 
      array (
        'pagetitle' => 'Контакты',
        'checked' => 0,
        'desc' => '',
        'template' => 0,
        'published' => 1,
        'hidemenu' => 0,
        'template_name' => 'page',
        'alias' => 'contacts',
        'content_type' => 1,
        'parent' => 0,
        'richtext' => 0,
        'searchable' => 0,
        'uri_override' => 1,
        'uri' => 'contacts.html',
        'content' => '',
      ),
    ),
    'settings' => 
    array (
      'emailsender' => 'admin@s701.h1.bumodx.ru',
      'publish_default' => 1,
      'upload_maxsize' => '10485760',
      'locale' => 'ru_RU.utf-8',
      'auto_check_pkg_updates' => 0,
      'feed_modx_news_enabled' => 0,
      'feed_modx_security_enabled' => 0,
      'automatic_alias' => 1,
      'use_alias_path' => 1,
      'friendly_urls' => 1,
      'global_duplicate_uri_check' => 1,
      'link_tag_scheme' => 'full',
      'tiny.base_url' => '/',
      'tiny.path_options' => 'rootrelative',
      'friendly_alias_translit' => 'russian',
      'password_generated_length' => 6,
      'password_min_length' => 6,
      'signupemail_message' => '<p>Здравствуйте [[+uid]],</p><p>Ваши данные для административного входа на [[+sname]]:</p>
                <p><strong>Логин:</strong> [[+uid]]<br /><strong>Пароль:</strong> [[+pwd]]<br /></p>
                <p>После того как вы войдете в административную часть MODX [[+surl]], вы можете изменить свой пароль.</p>
                <p>С уважением, <br />Администрация сайта</p>',
    ),
    'packages' => 
    array (
      'pdoTools' => 
      array (
        'pagetitle' => 'pdoTools',
        'checked' => 1,
        'desc' => 'Микро-библиотека для быстрой выборки данных из СУБД MySql через PDO.',
        'versions' => '2.1.0-pl',
        'link' => 'https://modstore.pro/packages/utilities/pdotools',
      ),
      'MinifyX' => 
      array (
        'pagetitle' => 'MinifyX',
        'checked' => 1,
        'desc' => 'Автоматизированное сжатие скриптов и стилей сайта.',
        'versions' => '1.4.2-pl',
        'link' => 'https://modstore.pro/packages/utilities/minifyx',
      ),
      'translit' => 
      array (
        'pagetitle' => 'translit',
        'checked' => 1,
        'desc' => 'генерации дружественных url',
        'versions' => '1.0.0-beta',
        'analog' => 'yTranslit',
        'link' => 'http://modx.com/extras/package/translit',
      ),
      'yTranslit' => 
      array (
        'pagetitle' => 'yTranslit',
        'checked' => 0,
        'desc' => 'генерации дружественных url через api переводчика Яндекс.',
        'versions' => '1.1.2-pl',
        'form' => '',
        'analog' => 'translit',
        'link' => 'https://modstore.pro/packages/content/ytranslit',
      ),
      'Ace' => 
      array (
        'pagetitle' => 'Ace',
        'checked' => 1,
        'desc' => 'Лучший редактор кода с подсветкой',
        'versions' => '1.6.5-pl',
        'analog' => 'CodeMirror',
        'link' => 'https://modstore.pro/packages/content/ace',
      ),
      'CodeMirror' => 
      array (
        'pagetitle' => 'CodeMirror',
        'checked' => 0,
        'desc' => 'Редактор кода с подсветкой',
        'versions' => '1.6.5-pl',
        'analog' => 'Ace',
        'link' => 'http://modx.com/extras/package/codemirror',
      ),
      'CKEditor' => 
      array (
        'pagetitle' => 'CKEditor',
        'checked' => 1,
        'desc' => 'Редактор текста в документах',
        'versions' => '',
        'analog' => 'TinyMCE',
        'link' => 'http://modx.com/extras/package/ckeditor',
      ),
      'TinyMCE' => 
      array (
        'pagetitle' => 'TinyMCE',
        'checked' => 0,
        'desc' => 'Редактор текста в документах',
        'versions' => '',
        'analog' => 'CKEditor',
        'link' => 'http://modx.com/extras/package/tinymce',
      ),
      'modAccessManager' => 
      array (
        'pagetitle' => 'modAccessManager',
        'checked' => 0,
        'desc' => 'Ограничение доступа для менеджера сайта',
        'versions' => '',
        'link' => 'https://modstore.pro/packages/users/modaccessmanager',
      ),
      'ClientConfig' => 
      array (
        'pagetitle' => 'ClientConfig',
        'checked' => 1,
        'desc' => 'клиентские настройки',
        'versions' => '1.4.0-pl',
        'link' => 'http://modx.com/extras/package/clientconfig',
      ),
      'miniShop2' => 
      array (
        'pagetitle' => 'miniShop2',
        'checked' => 0,
        'desc' => 'компонент интернет-магазина',
        'versions' => '2.2.0-pl2',
        'link' => 'https://modstore.pro/packages/ecommerce/minishop2',
      ),
      'mspReceiptAccount' => 
      array (
        'pagetitle' => 'mspReceiptAccount',
        'checked' => 0,
        'desc' => 'Квитанция и счет на оплату для интернет-магазина minishop',
        'versions' => '',
        'link' => 'https://modstore.pro/packages/payment-system/mspreceiptaccount',
      ),
    ),
    'dir' => '/home/s701/www/modMySettings/assets/components/modmysettings/',
    'setup-options' => 'modmysettings-1.0.0-rc/setup-options.php',
  ),
  'manifest-vehicles' => 
  array (
    0 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modNamespace',
      'guid' => '1bcda04a209ab172e5cc1cf3a9e729a6',
      'native_key' => 'modmysettings',
      'filename' => 'modNamespace/195c35c5dbae53418e287e5d2bc37f1d.vehicle',
      'namespace' => 'modmysettings',
    ),
    1 => 
    array (
      'vehicle_package' => 'transport',
      'vehicle_class' => 'xPDOObjectVehicle',
      'class' => 'modCategory',
      'guid' => '508c2bddaef77139abe4b14d85edf6b1',
      'native_key' => 1,
      'filename' => 'modCategory/ce2e093c409853634d322c6fa191227c.vehicle',
      'namespace' => 'modmysettings',
    ),
  ),
);