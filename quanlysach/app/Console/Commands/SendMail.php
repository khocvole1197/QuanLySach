<?php

namespace App\Console\Commands;

use App\Mail\SendEmail;
use App\Mail\SendEmailUser;
use App\Repositories\Book\BookRepository;
use App\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;

class SendMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sendmail:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'gửi email cho khách hàng tới hạn.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $bookModel;
    public function __construct(BookRepository $bookModel)
    {
        $this->bookModel = $bookModel;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function handle()
    {
        $data = $this->bookModel->all()->where('day_to', Carbon::now()->toDateString());
        foreach ($data as $key) {
            $sendEmail = new SendEmail($key);
            Mail::to('admin@qlsach.ci')->send($sendEmail);
            sleep(5);
            $name = $key->user_r;
            $user = User::all()->where('name', $name)->first();
            $emailUser = $user->email;
            Mail::to($emailUser)->send(new SendEmailUser($key));
            sleep(5);
        }
    }
}
