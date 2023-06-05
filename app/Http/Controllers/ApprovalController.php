<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Approval;

class ApprovalController extends Controller
{
    // Render this page on clicking approval/reject link by admin user.
    public function process()
    {
        // $approval = Approval::where('token', $approvalToken)->first();

        // if ($approval) {
        //     // Update the approval status based on the request (approve/reject)
        //     $approval->status = true;
        //     $approval->save();

        //     // Add additional logic here, such as notifying the sender about the approval/rejection

        //     return "Thank you for your response. The approval has been ";
        // }

        return redirect('login');
   }
}
