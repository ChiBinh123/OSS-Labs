<?php
declare(strict_types=1);

final class RegistrationPolicy {
    public function decide(
        int $capacity,
        int $registered,
        bool $open,
        bool $waitingEnabled
    ): string {

        // Du lieu khong hop le
        if ($capacity <= 0 || $registered < 0 || $registered > $capacity) {
            return 'rejected';
        }

        // Su kien da dong
        if (!$open) {
            return 'rejected';
        }

        // Su kien van con cho
        if ($registered < $capacity) {
            return 'confirmed';
        }

        // Su kien da day
        if ($waitingEnabled) {
            return 'waiting';
        }

        return 'rejected';
    }
}
