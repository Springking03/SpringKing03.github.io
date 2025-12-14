<?php
class ClinicModel {
    const TABLE_NAME = 'clinic';

    public function findAll()
    {
        return [
            [
                'id' => 1,
                'ten' => 'Phong Kham 858 Kim Giang'
            ],
            [
                'id' => 2,
                'ten' => 'Phong Kham 20 Ho Tung Mau'
            ],
            [
                'id' => 3,
                'ten' => 'Phong Kham 36 Ly Thai To'
            ],
        ];
    }

    public function findById($id)
    {
        return __METHOD__;
    }

    public function delete($id)
    {
        return __METHOD__;
    }
}