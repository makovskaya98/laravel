<?php

namespace App\Livewire;

use App\Models\Files;
use App\Models\PhoneNumbers;
use App\Models\UserDetails;
use App\Rules\PhoneOrEmailFilledRule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class UserForm extends Component
{
    use WithFileUploads;

    public $isFormValid = false;
    public $firstname;
    public $lastname;
    public $surname;
    public $birthdate;
    public $email;
    public $phonenumbers = [];
    public $storagePath;
    public $phoneOrEmailFilled;
    public $selectedstatus;
    public $aboutme;
    public $files;
    public $agreement;
    public $openmodal = true;
    public $familystatus = [
        'Холост/не замужем',
        'Женат/замужем',
        'В разводе',
        'Вдовец/вдова'
    ];
    public $countryCode = [
        '+375',
        '+7'
    ];
    public $maxFiles = 5;
    public $maxClonePhoneNum = 5;


    public function __construct()
    {
        $this->controller = new Controller();
    }

    public function rules()
    {
        return [
            'firstname' => 'required|alpha|min:2|max:50',
            'lastname' => 'required|alpha|min:2|max:50',
            'surname' => 'required|alpha|min:2|max:50',
            'birthdate' => 'required',
            'email' => 'nullable|email',
            'phonenumbers.*.countrycode' => 'nullable|string',
            'phonenumbers.*.phone' => 'nullable|string',
            'phoneOrEmailFilled' => new PhoneOrEmailFilledRule(['phonenumbers' => $this->phonenumbers, 'email' => $this->email]),
            'selectedstatus' => 'required|not_in:0',
            'aboutme' => 'required|min:20|max:1000',
            'agreement' => 'required|accepted',
            'files' => 'nullable|max:5',
            'files.*' => 'nullable|file|mimes:jpg,png,pdf|max:5120',
        ];
    }

    public function mount()
    {
        $this->phonenumbers[] = ['countrycode' => '+375', 'phone' => ''];
    }

    public function addPhoneNumber()
    {
        if (count($this->phonenumbers) < $this->maxClonePhoneNum) {
            $this->phonenumbers[] = ['countrycode' => '+375', 'phone' => ''];
        }
    }

    public function updatedCountrycode($key, $value)
    {
        $this->phonenumbers[$key]->countrycode = $value;
    }

    public function updatedPhone($key, $value)
    {
        $this->phonenumbers[$key]->phone = $value;
    }

    public function removePhoneNumber($index)
    {
        unset($this->phonenumbers[$index]);
    }

    public function updatedFiles()
    {
        if (count($this->files) > $this->maxFiles) {
            $this->files = array_slice($this->files, 0, $this->maxFiles);
        }
    }

    public function removeFile($index)
    {
        unset($this->files[$index]);
    }


    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);

        $fields = ['firstname', 'lastname', 'surname', 'birthdate', 'phoneOrEmailFilled', 'selectedstatus', 'aboutme', 'agreement'];

        foreach ($fields as $field) {
            if (!$this->validateOnly($field)) {
                $this->isFormValid = false;
            }
        }

        $this->isFormValid = true;
    }

    public function messages()
    {
        return $this->controller->messages();
    }

    public function render()
    {
        return view('livewire.user-form');
    }

    public function submit(): void
    {
        $this->validate();

        $userInfo = new UserDetails();
        $userInfo->firstname = $this->firstname;
        $userInfo->lastname = $this->lastname;
        $userInfo->surname = $this->surname;
        $userInfo->birthdate = $this->birthdate;
        $userInfo->email = $this->email;
        $userInfo->selectedstatus = $this->selectedstatus;
        $userInfo->aboutme = $this->aboutme;
        $userInfo->save();

        if (isset($this->files) && !empty($this->files)) {

            foreach ($this->files as $file) {

                $extension = $file->getClientOriginalExtension();
                $path = $extension === 'pdf' ? 'pdffiles' : 'images';

                $storedPath = $file->storeAs($path, $file->getClientOriginalName());
                $url = Storage::disk('local')->url($storedPath);
                $this->storagePath[] = ['filename' => $file->getClientOriginalName(), 'url' => $url];
                $filesInfo = new Files();
                $filesInfo->path = $url;
                $filesInfo->user_details_id = $userInfo->id;
                $filesInfo->save();
            }
        }

        foreach ($this->phonenumbers as $phone) {

            if (isset($phone['countrycode']) && !empty($phone['countrycode']) && isset($phone['phone']) && !empty($phone['phone'])) {

                $phone = preg_replace("/[\s\(\)\-]/", "", $phone['countrycode'] . '' . $phone['phone']);

                $phoneNumber = new PhoneNumbers();
                $phoneNumber->phone = $phone;
                $phoneNumber->user_details_id = $userInfo->id;
                $phoneNumber->save();
            }
        }


        $this->openmodal = false;
    }
}
