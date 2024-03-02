<div class="container">
    <div class="row">
        @if($openmodal)
            <div class="col-md-6 mx-auto">

                <form wire:submit.prevent="submit">
                    <div class="mb-3">
                        <label for="firstname">Имя</label>
                        <input type="text" class="form-control  @error('firstname') is-invalid @enderror"
                               wire:model.change="firstname" id="firstname"
                               placeholder="Введите имя">
                        @error('firstname')
                        <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="lastname">Фамилия</label>
                        <input type="text" class="form-control @error('lastname') is-invalid @enderror"
                               wire:model.change="lastname" id="lastname"
                               placeholder="Введите фамилию">
                        @error('lastname')
                        <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="surname">Отчество</label>
                        <input type="text" class="form-control @error('surname') is-invalid @enderror"
                               wire:model.change="surname" id="surname"
                               placeholder="Введите отчество">
                        @error('surname')
                        <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="birthdate">Дата рождения</label>
                        <input type="date" class="form-control @error('birthdate') is-invalid @enderror"
                               wire:model.change="birthdate" id="birthdate">
                        @error('birthdate')
                        <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email">Email</label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                               wire:model.change="email" id="email"
                               placeholder="Введите email">
                        @error('email')
                        <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone">Телефон</label>
                        @foreach ($phonenumbers as $key => $phonenumber)
                            <div class="input-group flex-nowrap">
                                <select class="input-group-text" name="phonenumbers.{{ $key }}.countrycode"
                                        wire:model.change="phonenumbers.{{ $key }}.countrycode">
                                    @foreach($countryCode as $code)
                                        <option value="{{$code}}">{{$code}}</option>
                                    @endforeach
                                </select>
                                <input class="form-control phone-number" type="tel" name="phonenumbers.{{ $key }}.phone"
                                       wire:model.change="phonenumbers.{{ $key }}.phone" >
                                @if ($key == 0)
                                    <div class="input-group-text phone-btn">
                                        <a wire:click="addPhoneNumber">+</a>
                                    </div>
                                @else
                                    <div class="input-group-text phone-btn">
                                        <a wire:click="removePhoneNumber({{$key}})">-</a>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                        @error('phone')
                        <div class="error">{{ $message }}</div> @enderror
                    </div>


                    @error('phoneOrEmailFilled') <span class="error">{{ $message }}</span> @enderror

                    <div class="mb-3">
                        <label for="family-status">Семейное положение:</label>
                        <select class="form-select @error('selectedstatus') is-invalid @enderror" id="family-status"
                                wire:model.change="selectedstatus">
                            <option value="0" selected>Не выбрано</option>
                            @foreach($familystatus as $key => $status)
                                <option value="{{$key + 1}}">{{$status}}</option>
                            @endforeach
                        </select>
                        @error('selectedstatus')
                        <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                    <textarea class="form-control" placeholder="О себе" id="about-me" rows="3"
                              wire:model.change="aboutme"
                              maxlength="1000"></textarea>
                        @error('aboutme')
                        <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <input type="file" name="files[]" wire:model.change="files" multiple
                               accept=".jpg,.png,.pdf"
                               max="5"/>
                        <div>
                            @if (!empty($files))
                                <ul class="files-list">
                                    @foreach ($files as $key => $file)
                                        <li>
                                            {{ $file->getClientOriginalName() }}
                                            <span class="remove-file" wire:click="removeFile({{$key}})">
                                                <img width="20"
                                                     height="20"
                                                     src="https://img.icons8.com/color/20/delete-sign--v1.png"
                                                     alt="delete-sign--v1"/>
                                            </span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        @error('files')
                        <div class="error">{{ $message }}</div>@enderror
                        @error('files.*')
                        <div class="error">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <input class="form-check-input" type="checkbox" value="" id="agreement"
                               wire:model.change="agreement">
                        <label class="form-check-label" for="agreement">
                            Я ознакомился c правилами
                        </label>
                        @error('agreement')
                        <div class="error">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                            @if (!$isFormValid) disabled @endif>
                        Отправить
                    </button>
                </form>
            </div>
        @else
            <div class="mb-12">
                <div class="success-block">
                    <div class="alert alert-primary" role="alert">
                        Форма успешно отправлена!
                    </div>
                    <div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#Поля</th>
                                <th scope="col">Пользователь</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <th scope="row">Имя</th>
                                <td>{{$firstname}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Фамилия</th>
                                <td>{{$lastname}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Отчество</th>
                                <td>{{$surname}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Дата рождения</th>
                                <td>{{$birthdate}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Email</th>
                                <td>{{$email}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Телефон</th>
                                <td>
                                    @if(isset($phonenumbers) && !empty($phonenumbers))
                                        @foreach ($phonenumbers as $key => $phonenumber)
                                            @if(isset($phonenumber['countrycode']) && !empty($phonenumber['phone']))
                                                {{$phonenumber['countrycode']}}{{$phonenumber['phone']}}<br/>
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">Семейное положение</th>
                                <td>{{$familystatus[$selectedstatus-1]}}</td>
                            </tr>
                            <tr>
                                <th scope="row">О себе</th>
                                <td>{{$aboutme}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Файлы</th>
                                <td>
                                    @if(isset($storagePath) && !empty($storagePath))
                                        @foreach($storagePath as $storage)
                                            {{$storage['filename']}}<br/>
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
