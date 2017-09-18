<?php

class srActivitiesSnapshot extends xPDOSimpleObject
{
    public static function fields()
    {
        return
            [
                'id' => 'ID',
                'parent' => 'ID родителя',
                'pagetitle' => 'Заголовок',
                'longtitle' => 'Расширенный заголовок',
                'description' => 'Описание',
                'introtext' => 'Аннотация',
                'content' => 'Содержание',
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