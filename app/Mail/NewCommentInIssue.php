<?php

namespace App\Mail;

use App\Models\Comment;
use App\Models\Issue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewCommentInIssue extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Issue
     */
    public $issue;

    /**
     * @var Comment
     */
    public $comment;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Issue $issue, Comment $comment)
    {
        $this->issue = $issue;
        $this->comment = $comment;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.new-comment-issue');
    }
}
