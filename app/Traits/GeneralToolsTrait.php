<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

trait GeneralToolsTrait
{
    /**
     * Genera un código único basado en un prefijo y la fecha actual.
     *
     * @param string $prefix
     * @return string
     */
    public function generateUniqueCode(string $prefix = 'CODE'): string
    {
        return $prefix . '-' . strtoupper(Str::random(6)) . '-' . now()->format('YmdHis');
    }

    /**
     * Convierte una fecha a un formato amigable.
     *
     * @param string|null $date
     * @param string $format
     * @return string
     */
    public function formatFriendlyDate(?string $date, string $format = 'd-m-Y H:i'): string
    {
        if (is_null($date)) {
            return 'N/A';
        }

        return Carbon::parse($date)->format($format);
    }

    /**
     * Extrae la fecha de una cadena de fecha y hora.
     *
     * @param string|null $date
     * @param string $format
     * @return string
     */
    public function extractDateFromDateTime(string $dateTime): string
    {
        return Carbon::parse($dateTime)->format('Y-m-d');
    }

    /**
     * Extrae la hora de una cadena de fecha y hora.
     *
     * @param string|null $date
     * @param string $format
     * @return string
     */
    public function extractTimeFromDateTime(string $dateTime): string
    {
        return Carbon::parse($dateTime)->format('H:i');
    }

    /**
     * Verifica si una cadena es un JSON válido.
     *
     * @param string $string
     * @return bool
     */
    public function isValidJson(string $string): bool
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    /**
     * Calcula la diferencia en días entre dos fechas.
     *
     * @param string $startDate
     * @param string $endDate
     * @return int
     */
    public function calculateDateDifference(string $startDate, string $endDate): int
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        return $start->diffInDays($end);
    }

    /**
     * Sanitiza una cadena removiendo caracteres especiales.
     *
     * @param string $string
     * @return string
     */
    public function sanitizeString(string $string): string
    {
        return preg_replace('/[^A-Za-z0-9\-]/', '', $string);
    }
}
