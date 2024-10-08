<?php

namespace App\Listeners;

use App\Events\OrderListExceptionEvent;
use App\Models\User;
use App\Notifications\OrderListExcepNotification;
use Illuminate\Support\Facades\Log;
use Psr\Log\LoggerInterface;

class OrderListExceptionListener
{
    private LoggerInterface $logger;

    public function __construct()
    {
        $this->logger = Log::channel('order_list_exceptions');
    }

    /**
     * @param OrderListExceptionEvent $event
     * @return void
     */
    public function handle(OrderListExceptionEvent $event): void
    {
        $this->logException($event);
        $this->notifyAdmin();
    }

    /**
     * @param $event
     * @return void
     */
    private function logException($event): void
    {
        $this->logger->error(
            $event->throwable->getMessage() .
            $event->throwable->getTraceAsString()
        );
    }

    /**
     * @return void
     */
    private function notifyAdmin(): void
    {
        $admin = $this->getAdminUser();

        if (is_null($admin)) {
            $this->logger->error('Admin user not found!');
            return;
        }

        $admin->notify(new OrderListExcepNotification());
    }

    /**
     * @return User|null
     */
    private function getAdminUser(): ?User
    {
        return User::query()
            ->where('mobile', env('ADMIN_MOBILE'))
            ->first();
    }
}
