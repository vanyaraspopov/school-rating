<?php

class srActivitiesSnapshot extends xPDOSimpleObject
{
    const DOCUMENTS_DIR = 'userdata/snapshots/';

    public static function fields()
    {
        return
            [
                'id' => 'ID',               //  Нежелательно убирать или перемещать
                'parent' => 'ID родителя',  //  Нежелательно убирать или перемещать
                'template' => 'ID шаблона',  //  Нежелательно убирать или перемещать
                'pagetitle' => 'Заголовок',
                'longtitle' => 'Расширенный заголовок',
                'description' => 'Описание',
                'introtext' => 'Аннотация',
                'content' => 'Содержание',
                'published' => 'Опубликован',
            ];
    }

    public static function TVs()
    {
        return
            [
                'event-competence' => 'На развитие каких компетенций направлено',
                'event-auditory-duration' => 'Аудитория. Продолжительность',
                'event-auditory-sex' => 'Аудитория. Пол',
                'event-auditory-age' => 'Аудитория. Возраст',
                'event-incharge' => 'Ответственный',
                'event-address' => 'Адрес',
                'event-address-short' => 'Адрес (коротко)',
                'event-section' => 'Направление',
                'event-level' => 'Уровень',
                'event-date-start' => 'Дата начала',
                'event-date-end' => 'Дата завершения',
            ];
    }
}