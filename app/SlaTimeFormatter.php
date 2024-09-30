<?php

namespace App;

trait SlaTimeFormatter
{
    public function getSlaTimeFormattedAttribute($seconds)
    {
        // Calcular días, horas, minutos y segundos
        $days = floor($seconds / 86400);
        $seconds %= 86400;

        $hours = floor($seconds / 3600);
        $seconds %= 3600;

        $minutes = floor($seconds / 60);
        $seconds = $seconds % 60;

        // Crear una lista para almacenar las partes que no son cero
        $parts = [];

        if ($days > 0) {
            $parts[] = "$days día" . ($days > 1 ? 's' : '');
        }
        if ($hours > 0) {
            $parts[] = "$hours hora" . ($hours > 1 ? 's' : '');
        }
        if ($minutes > 0) {
            $parts[] = "$minutes minuto" . ($minutes > 1 ? 's' : '');
        }
        if ($seconds > 0) {
            $parts[] = "$seconds segundo" . ($seconds > 1 ? 's' : '');
        }

        return !empty($parts) ? implode(', ', $parts) : '0 segundos';
    }
}