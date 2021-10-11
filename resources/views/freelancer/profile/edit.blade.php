<x-app-layout>
    <!-- Row -->
    <div class="row">
        <form action="{{ route('freelancer.profile.edit') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('put')

        
        <!-- Dashboard Box -->
        <div class="col-xl-12">
            <div class="dashboard-box margin-top-0">

                <!-- Headline -->
                <div class="headline">
                    <h3><i class="icon-material-outline-account-circle"></i> My Account</h3>
                </div>

                <div class="content with-padding padding-bottom-0">

                    <div class="row">

                        <div class="col-auto">
                            <div class="avatar-wrapper" data-tippy-placement="bottom" title="Change Avatar">
                                <img class="profile-pic" src="{{ asset('storage/' . $profile->profile_photo_path) }}" alt="" />
                                <div class="upload-button"></div>
                                <input name="profile_photo" class="file-upload" type="file" accept="image/*" />
                            </div>
                        </div>

                        <div class="col">
                            <div class="row">

                                <div class="col-xl-6">
                                    <div class="submit-field">
                                        <h5>First Name</h5>
                                        <input type="text" class="with-border" name="first_name" value="{{ $profile->first_name }}">
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="submit-field">
                                        <h5>Last Name</h5>
                                        <input type="text" class="with-border"  name="last_name" value="{{ $profile->last_name }}">
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <!-- Account Type -->
                                    <div class="submit-field">
                                        <h5>Account Type</h5>
                                        <div class="account-type">
                                            <div>
                                                <input type="radio" name="account-type-radio" id="freelancer-radio" class="account-type-radio" checked />
                                                <label for="freelancer-radio" class="ripple-effect-dark"><i class="icon-material-outline-account-circle"></i> Freelancer</label>
                                            </div>

                                            <div>
                                                <input type="radio" name="account-type-radio" id="employer-radio" class="account-type-radio" />
                                                <label for="employer-radio" class="ripple-effect-dark"><i class="icon-material-outline-business-center"></i> Employer</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="submit-field">
                                        <h5>Email</h5>
                                        <input type="text" class="with-border"  name="email" value="{{ $user->email }}">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Dashboard Box -->
        <div class="col-xl-12">
            <div class="dashboard-box">

                <!-- Headline -->
                <div class="headline">
                    <h3><i class="icon-material-outline-face"></i> My Profile</h3>
                </div>

                <div class="content">
                    <ul class="fields-ul">
                        <li>
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="submit-field">
                                        <div class="bidding-widget">
                                            <!-- Headline -->
                                            <span class="bidding-detail">Set your <strong>minimal hourly rate</strong></span>

                                            <!-- Slider -->
                                            <div class="bidding-value margin-bottom-10">$<span id="biddingVal"></span></div>
                                            <input class="bidding-slider" type="text" name="hourly_rate" value="{{ $profile->hourly_rate }}" data-slider-handle="custom" data-slider-currency="$" data-slider-min="5" data-slider-max="150" data-slider-value="{{ $profile->hourly_rate }}" data-slider-step="1" data-slider-tooltip="hide" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4">
                                    <div class="submit-field">
                                        <h5>Skills <i class="help-icon" data-tippy-placement="right" title="Add up to 10 skills"></i></h5>

                                        <!-- Skills List -->
                                        <div class="keywords-container">
                                            <div class="keyword-input-container">
                                                <input type="text" class="keyword-input with-border" placeholder="e.g. Angular, Laravel" />
                                                <button class="keyword-input-button ripple-effect"><i class="icon-material-outline-add"></i></button>
                                            </div>
                                            <div class="keywords-list">
                                                <span class="keyword"><span class="keyword-remove"></span><span class="keyword-text">Angular</span></span>
                                                <span class="keyword"><span class="keyword-remove"></span><span class="keyword-text">Vue JS</span></span>
                                                <span class="keyword"><span class="keyword-remove"></span><span class="keyword-text">iOS</span></span>
                                                <span class="keyword"><span class="keyword-remove"></span><span class="keyword-text">Android</span></span>
                                                <span class="keyword"><span class="keyword-remove"></span><span class="keyword-text">Laravel</span></span>
                                            </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-4">
                                    <div class="submit-field">
                                        <h5>Attachments</h5>

                                        <!-- Attachments -->
                                        <div class="attachments-container margin-top-0 margin-bottom-0">
                                            <div class="attachment-box ripple-effect">
                                                <span>Cover Letter</span>
                                                <i>PDF</i>
                                                <button class="remove-attachment" data-tippy-placement="top" title="Remove"></button>
                                            </div>
                                            <div class="attachment-box ripple-effect">
                                                <span>Contract</span>
                                                <i>DOCX</i>
                                                <button class="remove-attachment" data-tippy-placement="top" title="Remove"></button>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>

                                        <!-- Upload Button -->
                                        <div class="uploadButton margin-top-0">
                                            <input class="uploadButton-input" type="file" accept="image/*, application/pdf" id="upload" multiple />
                                            <label class="uploadButton-button ripple-effect" for="upload">Upload Files</label>
                                            <span class="uploadButton-file-name">Maximum file size: 10 MB</span>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="submit-field">
                                        <h5>Tagline</h5>
                                        <input type="text" class="with-border" name="title" value="{{ $profile->title }}">
                                    </div>
                                </div>

                                <div class="col-xl-6">
                                    <div class="submit-field">
                                        <h5>Nationality</h5>
                                        <x-country-select :selected="$profile->country" />
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="submit-field">
                                        <h5>Introduce Yourself</h5>
                                        <textarea cols="30" rows="5" class="with-border" name="description">{{ $profile->description }}</textarea>
                                    </div>
                                </div>

                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Dashboard Box -->
        <div class="col-xl-12">
            <div id="test1" class="dashboard-box">

                <!-- Headline -->
                <div class="headline">
                    <h3><i class="icon-material-outline-lock"></i> Password & Security</h3>
                </div>

                <div class="content with-padding">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="submit-field">
                                <h5>Current Password</h5>
                                <input type="password" class="with-border">
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="submit-field">
                                <h5>New Password</h5>
                                <input type="password" class="with-border">
                            </div>
                        </div>

                        <div class="col-xl-4">
                            <div class="submit-field">
                                <h5>Repeat New Password</h5>
                                <input type="password" class="with-border">
                            </div>
                        </div>

                        <div class="col-xl-12">
                            <div class="checkbox">
                                <input type="checkbox" id="two-step" checked>
                                <label for="two-step"><span class="checkbox-icon"></span> Enable Two-Step Verification via Email</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Button -->
        <div class="col-xl-12">
            <button type="submit" class="button ripple-effect big margin-top-30">Save Changes</button>
        </div>

        </form>

    </div>
    <!-- Row / End -->
</x-app-layout>