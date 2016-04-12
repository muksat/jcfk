<?php


class StudentRoomAndOrderFormCart extends RawMigration
{
    protected function addMigrations()
    {
        $this->addMigration('007', 'order_form_per_student');
        $this->addMigration('008', 'meal_description');
        $this->addMigration('009', 'student_remove_room');
        $this->addMigration('010', 'add_order_form_fields');
    }
}
