<?php

namespace App\Models\Interfaces;

interface AuditableInterface
{
    public function createdBy();

    public function updatedBy();

    public function deletedBy();
}