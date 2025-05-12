<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">User Referrals</h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addReferralModal">
            Add Referral
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="referrals-table" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Premium') }}</th>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be loaded via AJAX -->
                </tbody>
            </table>
        </div>

        <!-- Button trigger modal -->


        <!-- Modal -->
        <div class="modal fade" id="addReferralModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Referral</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="referralForm">
                        <div class="modal-body">
                            <div class="alert alert-success d-none" id="referral-success-message"></div>
                            <div class="alert alert-danger d-none" id="referral-error-message"></div>
                            <div class="mb-3">
                                <label for="referral_id" class="form-label">Select User</label>
                                <select class="form-control w-100" id="referral_id" name="referral_id">
                                    <option value="">Select User</option>
                                </select>
                                <div class="form-text">Search for a user by name or email to add as a referral</div>
                            </div>
                            <input type="hidden" name="user_id" id="user_id" value="{{ $user->id }}">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="submitReferral">Add Referral</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
