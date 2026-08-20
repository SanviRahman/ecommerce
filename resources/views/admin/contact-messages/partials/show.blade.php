<div class="card bg-light border-0 p-3 shadow-sm mb-3">
    <div class="row small">
        <div class="col-md-6 mb-3">
            <strong>Sender Name:</strong><br><span class="text-dark font-weight-bold">{{ $message->name }}</span>
        </div>
        <div class="col-md-6 mb-3">
            <strong>Email Address:</strong><br><span class="text-dark">{{ $message->email ?: 'N/A' }}</span>
        </div>
        <div class="col-md-6 mb-3">
            <strong>Phone Number:</strong><br><span class="text-dark">{{ $message->phone ?: 'N/A' }}</span>
        </div>
        <div class="col-md-6 mb-3">
            <strong>Status:</strong><br>
            <span class="badge badge-info text-uppercase mt-1">{{ $message->status }}</span>
        </div>
        <div class="col-12 mb-3">
            <strong>Subject:</strong><br><span class="text-dark font-weight-bold">{{ $message->subject ?: 'No Subject' }}</span>
        </div>
        <div class="col-12 mb-2">
            <strong>Message Content:</strong><br>
            <div class="p-3 bg-white border rounded text-dark mt-1" style="white-space: pre-line;">{{ $message->message }}</div>
        </div>
    </div>
</div>

<div class="text-right border-top pt-3 mt-4 bg-white rounded-bottom">
    <button type="button" class="btn btn-secondary font-weight-bold px-5 shadow-sm" data-dismiss="modal">Close</button>
</div>