<?php
include_once 'setting.inc.php';

$_lang['schoolrating'] = 'Школа Рейтинг';
$_lang['schoolrating_menu_desc'] = 'Специально для проекта Школа Рейтинг';
$_lang['schoolrating_intro_msg'] = 'Здесь можно настроить параметры мероприятий.';

$_lang['schoolrating_items'] = 'Предметы';
$_lang['schoolrating_item_id'] = 'Id';
$_lang['schoolrating_item_name'] = 'Название';
$_lang['schoolrating_item_description'] = 'Описание';
$_lang['schoolrating_item_active'] = 'Активно';

$_lang['schoolrating_item_create'] = 'Создать предмет';
$_lang['schoolrating_item_update'] = 'Изменить Предмет';
$_lang['schoolrating_item_enable'] = 'Включить Предмет';
$_lang['schoolrating_items_enable'] = 'Включить Предметы';
$_lang['schoolrating_item_disable'] = 'Отключить Предмет';
$_lang['schoolrating_items_disable'] = 'Отключить Предметы';
$_lang['schoolrating_item_remove'] = 'Удалить Предмет';
$_lang['schoolrating_items_remove'] = 'Удалить Предметы';
$_lang['schoolrating_item_remove_confirm'] = 'Вы уверены, что хотите удалить этот Предмет?';
$_lang['schoolrating_items_remove_confirm'] = 'Вы уверены, что хотите удалить эти Предметы?';
$_lang['schoolrating_item_active'] = 'Включено';

$_lang['schoolrating_item_err_name'] = 'Вы должны указать имя Предмета.';
$_lang['schoolrating_item_err_ae'] = 'Предмет с таким именем уже существует.';
$_lang['schoolrating_item_err_nf'] = 'Предмет не найден.';
$_lang['schoolrating_item_err_ns'] = 'Предмет не указан.';
$_lang['schoolrating_item_err_remove'] = 'Ошибка при удалении Предмета.';
$_lang['schoolrating_item_err_save'] = 'Ошибка при сохранении Предмета.';

$_lang['schoolrating_grid_search'] = 'Поиск';
$_lang['schoolrating_grid_actions'] = 'Действия';

//  Коэффициенты
$_lang['schoolrating_coefficients_intro_msg'] = 'Здесь можно настроить коэффициенты мероприятий.';

$_lang['schoolrating_coefficients'] = 'Коэффициенты';
$_lang['schoolrating_coefficient_id'] = 'ID';
$_lang['schoolrating_coefficient_name'] = 'Название';
$_lang['schoolrating_coefficient_value'] = 'Значение';
$_lang['schoolrating_coefficient_css_class'] = 'CSS класс';
$_lang['schoolrating_coefficient_css_class_help'] = 'CSS класс, используемый для отрисовки иконки.Не меняйте его значение, если не понимаете.';

$_lang['schoolrating_coefficient_create'] = 'Добавить коэффициент';
$_lang['schoolrating_coefficient_update'] = 'Изменить коэффициент';
$_lang['schoolrating_coefficient_remove'] = 'Удалить коэффициент';
$_lang['schoolrating_coefficients_remove'] = 'Удалить коэффициенты';
$_lang['schoolrating_coefficient_remove_confirm'] = 'Вы уверены, что хотите удалить этот коэффициент?';
$_lang['schoolrating_coefficients_remove_confirm'] = 'Вы уверены, что хотите удалить эти коэффициенты?';

//  Направления
$_lang['schoolrating_sections_intro_msg'] = 'Здесь можно настроить направления мероприятий.';

$_lang['schoolrating_section'] = 'Направление';
$_lang['schoolrating_sections'] = 'Направления';
$_lang['schoolrating_section_id'] = 'ID';
$_lang['schoolrating_section_name'] = 'Название';
$_lang['schoolrating_section_usergroup_id'] = 'Группа модераторов';

$_lang['schoolrating_section_create'] = 'Добавить направление';
$_lang['schoolrating_section_update'] = 'Изменить направление';
$_lang['schoolrating_section_remove'] = 'Удалить направление';
$_lang['schoolrating_sections_remove'] = 'Удалить направления';
$_lang['schoolrating_section_remove_confirm'] = 'Вы уверены, что хотите удалить это направление?';
$_lang['schoolrating_sections_remove_confirm'] = 'Вы уверены, что хотите удалить эти направления?';

//  Рейтинг
$_lang['schoolrating_rating_intro_msg'] = 'Здесь можно начислять баллы пользователям.';

$_lang['schoolrating_rating'] = 'Баллы';
$_lang['schoolrating_rating_id'] = 'ID';
$_lang['schoolrating_rating_user_id'] = 'ID пользователя';
$_lang['schoolrating_rating_date'] = 'Дата начисления';
$_lang['schoolrating_rating_rating'] = 'Баллы';
$_lang['schoolrating_rating_comment'] = 'Комментарий';

$_lang['schoolrating_rating_create'] = 'Начислить баллы';
$_lang['schoolrating_rating_update'] = 'Изменить запись';
$_lang['schoolrating_rating_remove'] = 'Удалить запись';
$_lang['schoolrating_ratings_remove'] = 'Удалить записи';
$_lang['schoolrating_rating_remove_confirm'] = 'Вы уверены, что хотите удалить эту запись? Это приведёт к списанию баллов.';
$_lang['schoolrating_ratings_remove_confirm'] = 'Вы уверены, что хотите удалить эти записи? Это приведёт к списанию баллов.';

//  Мероприятия
$_lang['schoolrating_activities_intro_msg'] = 'Здесь можно просмотреть мероприятия.';

$_lang['schoolrating_activities'] = 'Мероприятия';
$_lang['schoolrating_activity_id'] = 'ID';
$_lang['schoolrating_activity_name'] = 'Название';

$_lang['schoolrating_activity_create'] = 'Добавить мероприятие';
$_lang['schoolrating_activity_create_help'] = 'Создание новых мероприятий осуществляется через дерево ресурсов.';
$_lang['schoolrating_activity_update'] = 'Изменить мероприятие';
$_lang['schoolrating_activity_remove'] = 'Удалить мероприятие';
$_lang['schoolrating_activities_remove'] = 'Удалить мероприятия';
$_lang['schoolrating_activity_remove_confirm'] = 'Вы уверены, что хотите удалить это мероприятие?';
$_lang['schoolrating_activites_remove_confirm'] = 'Вы уверены, что хотите удалить эти мероприятия?';