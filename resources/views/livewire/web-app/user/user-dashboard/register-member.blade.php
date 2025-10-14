<div class="container-fluid">

    <!-- Page Heading -->

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Register Member</h1>
    </div>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Register Member</h6>
        </div>
        <div class="card-body">
            <form class="custom-validation row" wire:submit.prevent="submit">
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="agentid">Sponsor Id</label>
                    {{-- <input type="text" class="form-control" name="agentid" id="agentid" placeholder="Agent Id" onkeyup="get_sponcor_name()"> --}}
                    <input type="number" 
                                    wire:model.live="sponsor_id"
                                    class="form-control @error('sponsor_id') is-invalid @enderror"
                                    placeholder="Enter Sponsor ID">
                    @error('sponsor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="name">Sponsor Name</label>
                    <input type="text"
                                    class="form-control"
                                    value="{{ $sponsorName }}"
                                    wire:model="sponsorName"
                                    placeholder="Sponsor Name"
                                    readonly>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="name">Name</label>
                    <input type="text" wire:model="name" class="form-control" placeholder="Enter name">
                </div>
                <div class="mb-3 col-md-6">
                    <label class="font-weight-bold form-label" for="postion">Position</label>
                    <div class="input-group input-group-merge">
                        <select wire:model="position" class="form-control form-select">
                            <option value="left">Left</option>
                            <option value="right">Right</option>
                        </select>
                    </div>
                </div>
                <div class="mb-0 col-md-6">
                    <label class="form-label" for="input-email">Email address::</label>
                    <input type="email" wire:model="email" class="form-control" placeholder="Enter Email">
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label" for="phone">Phone No.</label>
                    <div>
                        <input type="text" wire:model="phone" class="form-control" placeholder="Enter phone number">
                    </div>
                </div>
                <!-- <div class="mb-3">
                    <label class="form-label" for="pass">Password</label>
                    <div>
                        <input type="password" name="password" id="pass" class="form-control" required placeholder="Enter Password">
                    </div>
                </div> -->
                @error('form') <div class="alert alert-danger">{{ $message }}</div> @enderror
                
                <div class="col-md-12 text-center">
                    <div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary waves-effect waves-light me-1">Add Member</button>
                    </div>

                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>


            </form>
        </div>
    </div>

    @if($showConfirmModal)
        <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); display: flex; justify-content: center; align-items: center; z-index: 1000;">
            <div style="background: white; border-radius: 12px; width: 90%; max-width: 500px; box-shadow: 0 10px 30px rgba(0,0,0,0.25); overflow: hidden;">
                <div style="padding: 20px; border-bottom: 1px solid #eaeaea; display: flex; justify-content: space-between; align-items: center;">
                    <h3 style="margin: 0; font-family: 'Segoe UI', Arial, sans-serif; color: #2c3e50; font-weight: 600;">Confirm Registration</h3>
                    <button style="background: none; border: none; font-size: 24px; cursor: pointer; color: #7f8c8d;" wire:click="$set('showConfirmModal',false)">×</button>
                </div>
                
                <div style="padding: 25px;" wire:ignore>
                    <div style="margin-bottom: 15px;">
                        <strong style="display: inline-block; width: 120px; color: #34495e;">Sponsor ID:</strong>
                        <span style="color: #2c3e50;">{{ $sponsor_id }}</span>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <strong style="display: inline-block; width: 120px; color: #34495e;">Sponsor Name:</strong>
                        <span style="color: #2c3e50;">{{ $sponsorName }}</span>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <strong style="display: inline-block; width: 120px; color: #34495e;">Name:</strong>
                        <span style="color: #2c3e50;">{{ $name }}</span>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <strong style="display: inline-block; width: 120px; color: #34495e;">Position:</strong>
                        <span style="color: #2c3e50;">{{ $position }}</span>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <strong style="display: inline-block; width: 120px; color: #34495e;">Email:</strong>
                        <span style="color: #2c3e50;">{{ $email }}</span>
                    </div>
                    <div style="margin-bottom: 15px;">
                        <strong style="display: inline-block; width: 120px; color: #34495e;">Phone:</strong>
                        <span style="color: #2c3e50;">{{ $phone }}</span>
                    </div>
                </div>
                
                <div style="padding: 20px; background: #f8f9fa; display: flex; justify-content: flex-end; gap: 10px;">
                    <button style="padding: 10px 20px; background: #95a5a6; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 500;" wire:click="$set('showConfirmModal',false)">Cancel</button>
                    <button style="padding: 10px 20px; background: #27ae60; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 500;" wire:click="register">Confirm & Register</button>
                </div>
            </div>
        </div>
    @endif

</div>