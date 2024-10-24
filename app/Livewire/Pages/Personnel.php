<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\Cycles;
use App\Models\Harvests;
use App\Models\Samplings;
use App\Models\Shrimps;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Kreait\Firebase\Contract\Database;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class Personnel extends Component
{
    use Actions;
    use WithPagination;

    public $name;
    // public $address;
    public $email;
    public $mobileNo;
    public $password;
    public $password_confirmation;

    public $selectedPersonnelId;
    public $editName;
    // public $editAddress;
    public $editEmail;
    public $editMobileNo;

    public function createNewPersonnel(){
        
        $this->validate([ 
            'name' => 'required|max:255',
            'email'=> 'required|email',
            'mobileNo' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        $newPersonnel = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'mobile_no' => '+63' . $this->mobileNo,
            'role' => 'user',
            'password' => Hash::make($this->password)
        ]);

        Notification::make()
            ->title('Success!')
            ->body('Personnel has been created.')
            ->success()
            ->send();
        

        $this->dispatch('reload');
        return redirect()->back();
    }

    public function cancelCreate(){
        $this->name = "";
        $this->email = "";
        $this->mobileNo = "";
    }

    // EDIT
    public function getSelectedPersonnel($id){
        $personnel = User::findOrFail($id);

        if($personnel && $id){
            $this->selectedPersonnelId = $id;
            $this->editName = $personnel->name;
            $this->editEmail = $personnel->email;
            $this->editMobileNo = $personnel->mobile_no;
        }
    }

    public function editSelectedPersonnel($id){
        if($this->selectedPersonnelId){
            $this->validate([ 
                'editName' => 'required|max:255',
                'editEmail'=> 'required|email',
                'editMobileNo' => 'required',
            ]);
    
            $personnel = User::findOrFail($id);
    
            $personnel->update([
                'name' => $this->editName,
                'email' => $this->editEmail,
                'mobile_no' => '+63' . $this->editMobileNo,
            ]);

            Notification::make()
                ->title('Success!')
                ->body('Personnel details has been updated.')
                ->success()
                ->send();

            $this->cancelEdit();
            $this->dispatch('reload');

            return redirect()->back();
        }
    }

    public function editPersonnelConfirmation($id){
        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => "Do you want to edit this personnel with ID No. ".  html_entity_decode('<span class="text-red-600 underline">' . $id . '</span>') . " ?",
            'acceptLabel' => 'Yes, update it',
            'method'      => 'editSelectedPersonnel',
            'icon'        => 'error',
            'params'      => $id
        ]);
    }

    public function cancelEdit(){
        $this->editName = "";
        $this->editEmail = "";
        $this->editMobileNo = "";
    }

    // DELETE
    public function deletePersonnel($id){
        $personnel = User::findOrFail($id);
        $personnel->delete();

        Notification::make()
            ->title('Success!')
            ->body('Personnel has been deleted.')
            ->success()
            ->send();

        $this->dispatch('reload');

        return redirect()->back();
    }

    public function deletePersonnelConfirmation($id, $personnelName){
        $this->dialog()->confirm([
            'title'       => 'Are you Sure?',
            'description' => "Do you want to remove this personnel Name: ".  html_entity_decode('<span class="text-red-600 underline">' . $personnelName . '</span>') . " ?",
            'acceptLabel' => 'Yes, delete it',
            'method'      => 'deletePersonnel',
            'icon'        => 'error',
            'params'      => $id
        ]);
    }

    public function render()
    {
        $personnelLists = User::where('role', 'user')->get();
        return view('livewire.pages.personnel', [
            'personnelLists' => $personnelLists
        ]);
    }
}
