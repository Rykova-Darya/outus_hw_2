<?php

namespace App\Services;

class LuckyTicketService
{
    public function isLuckyTicket(int $n, int $outResult, string $fileName)
    {

        $sum1 = array_fill(0, 10, 1);

        for ($i = 1; $i < $n; $i++) {
            $sum2 = [];
            for ($j = 0; $j < count($sum1) + 10; $j++) {
                $sum = 0;
                for ($k = max(0, $j - 9); $k <= $j && $k < count($sum1); $k++) {
                    $sum += $sum1[$k];
                }
                $sum2[] = $sum;
            }
            $sum1 = $sum2;
        }

        // Расчёт количества счастливых билетов
        $result = 0;
        foreach ($sum1 as $x) {
            $result += $x * $x;
        }

        if ($outResult === $result) {
            return 'Тест ' . $fileName . ' OK: ' . $result;
        } else {
            return 'Тест ' . $fileName . ' ошибка ' . $result . ' ожидалось ' . $outResult;
        }
    }

}