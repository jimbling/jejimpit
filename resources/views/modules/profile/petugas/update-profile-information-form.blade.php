  <section class="mx-auto  p-2">

      <form id="send-verification" method="post" action="{{ route('verification.send') }}">
          @csrf
      </form>

      <div class="flex items-center mb-6 space-x-4">
          <div>
              <!-- Avatar Image -->
              <div class="h-20 w-20 rounded-full bg-cover bg-center"
                  style="background-image: url({{ asset('storage/avatars/' . ($user->avatar ?? 'default-avatar.png')) }})">
              </div>
          </div>
          <div>
              <!-- Button to open the modal -->
              <button type="button"
                  class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors"
                  onclick="document.getElementById('uploadAvatarModal').classList.remove('hidden')">
                  Ubah avatar
              </button>
          </div>
          <div>
              <!-- Button to delete avatar -->
              <a href="{{ route('profile.delete-avatar') }}"
                  class="text-red-600 hover:text-red-800 px-4 py-2 border border-red-300 rounded-lg hover:bg-red-50 transition-colors">
                  Hapus avatar
              </a>
          </div>
      </div>

      <!-- Modal for uploading avatar -->
      <div id="uploadAvatarModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
          <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
              <div class="mt-3">
                  <div class="flex justify-between items-center pb-3">
                      <h3 class="text-xl font-semibold text-gray-800">Unggah Avatar Baru</h3>
                      <button onclick="document.getElementById('uploadAvatarModal').classList.add('hidden')"
                          class="text-gray-500 hover:text-gray-700">
                          <i class="fas fa-times"></i>
                      </button>
                  </div>

                  <!-- Form for uploading avatar -->
                  <form method="POST" action="{{ route('profile.update-avatar') }}" enctype="multipart/form-data">
                      @csrf
                      <div class="mb-4">
                          <label for="avatar" class="block text-gray-700 mb-2">Pilih Avatar</label>
                          <input type="file"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                              id="avatar" name="avatar" accept="image/*" required>
                          @error('avatar')
                              <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                          @enderror
                      </div>
                      <div class="flex justify-end pt-4 space-x-3">
                          <button type="button"
                              onclick="document.getElementById('uploadAvatarModal').classList.add('hidden')"
                              class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                              Tutup
                          </button>
                          <button type="submit"
                              class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                              Unggah
                          </button>
                      </div>
                  </form>
              </div>
          </div>
      </div>

      <form method="post" action="{{ route('profile.update') }}" class="mt-6">
          @csrf
          @method('patch')

          <div class="mb-5">
              <label for="name" class="block text-gray-700 mb-2">Name</label>
              <input id="name" name="name" type="text"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                  value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
              @error('name')
                  <div class="text-red-500 text-sm mt-1">
                      {{ $message }}
                  </div>
              @enderror
          </div>

          <div class="mb-5">
              <label for="email" class="block text-gray-700 mb-2">Email</label>
              <input id="email" name="email" type="email"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                  value="{{ old('email', $user->email) }}" required autocomplete="username" />
              @error('email')
                  <div class="text-red-500 text-sm mt-1">
                      {{ $message }}
                  </div>
              @enderror

              @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                  <div class="mt-3">
                      <p class="text-gray-600">
                          Your email address is unverified.

                          <button form="send-verification" class="text-blue-600 hover:text-blue-800 ml-1">
                              Click here to re-send the verification email.
                          </button>
                      </p>

                      @if (session('status') === 'verification-link-sent')
                          <p class="text-green-600 mt-2">
                              A new verification link has been sent to your email address.
                          </p>
                      @endif
                  </div>
              @endif
          </div>

          <div class="flex items-center space-x-4">
              <button type="submit"
                  class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">Save</button>

              @if (session('status') === 'profile-updated')
                  <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-green-600">
                      Saved.
                  </p>
              @endif
          </div>
      </form>
  </section>
