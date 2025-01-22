@extends('layout.main')

@section('content')
<section class="bg-white dark:bg-gray-900">
  <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-12">
    <a href="#jasa"
      class="inline-flex justify-between items-center py-1 px-1 pr-4 mb-7 text-sm text-gray-700 bg-gray-100 rounded-full dark:bg-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700"
      role="alert">
      <span class="text-xs bg-purple-600 rounded-full text-white px-4 py-1.5 mr-3">Baru</span>
      <span class="text-sm font-medium">DreamZinc hadir</span><span class="ms-1 hidden md:inline">untuk mendukung
        mahasiswa!</span>
      <svg class="ml-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd"
          d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
          clip-rule="evenodd"></path>
      </svg>
    </a>
    <h1
      class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
      Solusi Digital untuk Mahasiswa</h1>
    <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400">DreamZinc hadir
      untuk membantu mahasiswa mencapai tujuan mereka dengan layanan digital yang inovatif dan mudah digunakan.</p>
    <div class="flex flex-col mb-8 lg:mb-16 space-y-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4">
      <a href="#jasa"
        class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-white rounded-lg bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 dark:focus:ring-purple-900">
        Selengkapnya
      </a>
      <a href="{{ url('https://wa.me/62895420984780') }}"
        class="inline-flex justify-center items-center py-3 px-5 text-base font-medium text-center text-gray-900 rounded-lg border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:text-white dark:border-gray-700 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
        Hubungi Kami
      </a>
    </div>
  </div>
</section>

<section id="jasa" class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-12">
  <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
    <div class="mb-4 items-center justify-between space-y-4 flex sm:space-y-0 md:mb-8">
      <div>
        <h2 class="mt-3 text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Jasa</h2>
      </div>
      <div class="flex items-center space-x-4">
        <button id="sortDropdownButton1" data-dropdown-toggle="dropdownSort1" type="button"
          class="flex items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 sm:w-auto">
          <svg class="-ms-0.5 me-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M7 4v16M7 4l3 3M7 4 4 7m9-3h6l-6 6h6m-6.5 10 3.5-7 3.5 7M14 18h4" />
          </svg>
          Filter Kategori
          <svg class="-me-0.5 ms-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="m19 9-7 7-7-7" />
          </svg>
        </button>
        <div id="dropdownSort1"
          class="z-10 hidden w-40 divide-y divide-gray-100 rounded-lg bg-white shadow dark:bg-gray-700"
          data-popper-placement="bottom">
          <ul class="p-2 text-left text-sm font-medium text-gray-500 dark:text-gray-400"
            aria-labelledby="sortDropdownButton">
            <li>
              <button onclick="filterCategory('all')"
                class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                Semua Kategori </button>
            </li>
            @foreach(App\Models\Category::get() as $category)
            <li>
              <button onclick="filterCategory('{{ strtolower(str_replace(' ', '', $category->name)) }}')"
                class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">{{ $category->name }}</button>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>

    <div class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4" id="product-container">
      @foreach(App\Models\Service::with('category', 'orders')->get() as $service)
      <div
        class="product-card {{ strtolower(str_replace(' ', '', $service->category->name)) }} rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="h-56 w-full">
          <img class="mx-auto h-full dark:hidden" src="{{ asset('storage/'.$service->photo) }}"
            alt="{{ $service->title }}" />
          <img class="mx-auto hidden h-full dark:block" src="{{ asset('storage/'.$service->photo) }}"
            alt="{{ $service->title }}" />
        </div>
        <div class="pt-6">
          <div class="mb-4 flex items-center justify-between gap-4">
            <span
              class="me-2 rounded bg-purple-100 px-2.5 py-0.5 text-xs font-medium text-purple-800 dark:bg-purple-900 dark:text-purple-300">{{ $service->category->name }}</span>
          </div>
          <h1 class="text-lg text-left font-semibold leading-tight text-gray-900 dark:text-white">
            {{ $service->title }}</h1>
          <ul class="mt-2 flex items-center gap-4">
            <li class="flex items-center gap-2">
              <svg class="-ms-2 h-5 w-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
              </svg>
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $service->orders->count() }} Pesanan
              </p>
            </li>
          </ul>
          <div class="mt-4 flex items-center justify-between gap-4">
            <p class="text-2xl font-extrabold leading-tight text-gray-900 dark:text-white"><span class="text-sm">Mulai
                Dari</span> Rp
              {{ number_format($service->price, 0, ",", ".") }}</p>
            <button data-modal-target="pesanModal{{ $service->id }}" data-modal-toggle="pesanModal{{ $service->id }}"
              type="button"
              class="inline-flex items-center rounded-lg bg-purple-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
              <svg class="-ms-2 me-2 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
              </svg>
              Pesan
            </button>
            <div id="pesanModal{{ $service->id }}" tabindex="-1" aria-hidden="true"
              class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
              <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                  <div
                    class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                      Pesan
                    </h3>
                    <button type="button"
                      class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                      data-modal-toggle="pesanModal{{ $service->id }}">
                      <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                          clip-rule="evenodd"></path>
                      </svg>
                      <span class="sr-only">Close modal</span>
                    </button>
                  </div>
                  <form action="{{ url('order-service/'.$service->id) }}" method="POST">
                    @csrf
                    <span
                      class="me-2 rounded bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">{{ $service->category->description }}</span>
                    <h4 class="text-md font-semibold text-gray-900 dark:text-white">
                      {{ $service->title }}
                    </h4>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400 mb-2">
                      {{ $service->description }}
                    </p>
                    <div class="grid gap-4 mb-4 grid-cols-1">
                      <input type="hidden" name="referral_code" value="{{ @$_GET['code'] }}">
                      <div>
                        <label for="name"
                          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                        <input type="text" name="name" id="name"
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                          placeholder="Masukkan nama" required>
                      </div>
                      <div>
                        <label for="whatsapp_number"
                          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor WhatsApp</label>
                        <input type="text" name="whatsapp_number" id="whatsapp_number"
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                          placeholder="Masukkan nomor WhatsApp" required>
                      </div>
                      <div>
                        <label for="deadline" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Batas
                          Waktu</label>
                        <input type="datetime-local" name="deadline" id="deadline"
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                          required>
                      </div>
                      <div>
                        <label for="description"
                          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                        <textarea id="description" name="description" rows="4"
                          class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-gray-500 focus:border-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                          placeholder="Masukkan deskripsi pesanan" required></textarea>
                      </div>
                    </div>
                    <button type="submit"
                      class="text-white inline-flex items-center bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                      <svg class="-ms-2 me-2 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                      </svg>
                      Pesan Sekarang
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<section id="kursus" class="bg-gray-50 py-8 antialiased dark:bg-gray-900 md:py-12">
  <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
    <div class="mb-4 items-center justify-between space-y-4 flex sm:space-y-0 md:mb-8">
      <div>
        <h2 class="mt-3 text-xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Kursus</h2>
      </div>
      <div class="flex items-center space-x-4">
        <button id="sortDropdownButton1" data-dropdown-toggle="dropdownSort2" type="button"
          class="flex items-center justify-center rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-900 hover:bg-gray-100 hover:text-gray-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700 sm:w-auto">
          <svg class="-ms-0.5 me-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M7 4v16M7 4l3 3M7 4 4 7m9-3h6l-6 6h6m-6.5 10 3.5-7 3.5 7M14 18h4" />
          </svg>
          Filter Kategori
          <svg class="-me-0.5 ms-2 h-4 w-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="m19 9-7 7-7-7" />
          </svg>
        </button>
        <div id="dropdownSort2"
          class="z-10 hidden w-40 divide-y divide-gray-100 rounded-lg bg-white shadow dark:bg-gray-700"
          data-popper-placement="bottom">
          <ul class="p-2 text-left text-sm font-medium text-gray-500 dark:text-gray-400"
            aria-labelledby="sortDropdownButton">
            <li>
              <button onclick="filterCategoryCrourse('all')"
                class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">
                Semua Kategori </button>
            </li>
            @foreach(App\Models\Category::get() as $category)
            <li>
              <button onclick="filterCategoryCrourse('{{ strtolower(str_replace(' ', '', $category->name)) }}')"
                class="group inline-flex w-full items-center rounded-md px-3 py-2 text-sm text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-600 dark:hover:text-white">{{ $category->name }}</button>
            </li>
            @endforeach
          </ul>
        </div>
      </div>
    </div>

    <div class="mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4" id="product-container">
      @foreach(App\Models\Course::with('category', 'orders')->get() as $course)
      <div
        class="product-card-course {{ strtolower(str_replace(' ', '', $course->category->name)) }} rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="h-56 w-full">
          <img class="mx-auto h-full dark:hidden" src="{{ asset('storage/'.$course->photo) }}"
            alt="{{ $course->title }}" />
          <img class="mx-auto hidden h-full dark:block" src="{{ asset('storage/'.$course->photo) }}"
            alt="{{ $course->title }}" />
        </div>
        <div class="pt-6">
          <div class="mb-4 flex items-center justify-between gap-4">
            <span
              class="me-2 rounded bg-purple-100 px-2.5 py-0.5 text-xs font-medium text-purple-800 dark:bg-purple-900 dark:text-purple-300">{{ $course->category->name }}</span>
          </div>
          <h1 class="text-lg text-left font-semibold leading-tight text-gray-900 dark:text-white">
            {{ $course->title }}</h1>
          <ul class="mt-2 flex items-center gap-4">
            <li class="flex items-center gap-2">
              <svg class="-ms-2 h-5 w-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
              </svg>
              <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $course->orders->count() }} Pesanan
              </p>
            </li>
          </ul>
          <div class="mt-4 flex items-center justify-between gap-4">
            <p class="text-2xl font-extrabold leading-tight text-gray-900 dark:text-white">Rp
              {{ number_format($course->price, 0, ",", ".") }}</p>
            <button data-modal-target="pesanModal{{ $course->id }}" data-modal-toggle="pesanModal{{ $course->id }}"
              type="button"
              class="inline-flex items-center rounded-lg bg-purple-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-purple-800 focus:outline-none focus:ring-4 focus:ring-purple-300 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
              <svg class="-ms-2 me-2 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" fill="none" viewBox="0 0 24 24">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
              </svg>
              Pesan
            </button>
            <div id="pesanModal{{ $course->id }}" tabindex="-1" aria-hidden="true"
              class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-modal md:h-full">
              <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                <div class="relative p-4 bg-white rounded-lg shadow dark:bg-gray-800 sm:p-5">
                  <div
                    class="flex justify-between items-center pb-4 mb-4 rounded-t border-b sm:mb-5 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                      Pesan
                    </h3>
                    <button type="button"
                      class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"
                      data-modal-toggle="pesanModal{{ $course->id }}">
                      <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                          d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                          clip-rule="evenodd"></path>
                      </svg>
                      <span class="sr-only">Close modal</span>
                    </button>
                  </div>
                  <form action="{{ url('order-course/'.$course->id) }}" method="POST">
                    @csrf
                    <span
                      class="me-2 rounded bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800 dark:bg-blue-900 dark:text-blue-300">{{ $course->category->description }}</span>
                    <h4 class="text-md font-semibold text-gray-900 dark:text-white">
                      {{ $course->title }}
                    </h4>
                    <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400 mb-2">
                      {{ $course->description }}
                    </p>
                    <div class="grid gap-4 mb-4 grid-cols-1">
                      <input type="hidden" name="referral_code" value="{{ @$_GET['code'] }}">
                      <div>
                        <label for="name"
                          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama</label>
                        <input type="text" name="name" id="name"
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                          placeholder="Masukkan nama" required>
                      </div>
                      <div>
                        <label for="whatsapp_number"
                          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor WhatsApp</label>
                        <input type="text" name="whatsapp_number" id="whatsapp_number"
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                          placeholder="Masukkan nomor WhatsApp" required>
                      </div>
                      <div>
                        <label for="deadline" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Batas
                          Waktu</label>
                        <input type="datetime-local" name="deadline" id="deadline"
                          class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-gray-600 focus:border-gray-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                          required>
                      </div>
                      <div>
                        <label for="description"
                          class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Deskripsi</label>
                        <textarea id="description" name="description" rows="4"
                          class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-gray-500 focus:border-gray-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-gray-500 dark:focus:border-gray-500"
                          placeholder="Masukkan deskripsi pesanan" required></textarea>
                      </div>
                    </div>
                    <button type="submit"
                      class="text-white inline-flex items-center bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:outline-none focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-800">
                      <svg class="-ms-2 me-2 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                        height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 4h1.5L8 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm.75-3H7.5M11 7H6.312M17 4v6m-3-3h6" />
                      </svg>
                      Pesan Sekarang
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>

<footer class="p-4 bg-white md:p-8 lg:p-10 dark:bg-gray-900">
  <div class="mx-auto max-w-screen-xl text-center">
    <a href="#" class="flex justify-center items-center text-2xl font-semibold text-gray-900 dark:text-white">
      DreamZinc
    </a>
    <p class="my-6 text-gray-500 dark:text-gray-400">Solusi digital untuk Mahasiswa.</p>
    <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2024 <a href="#"
        class="hover:underline">DreamZinc™</a></span>
  </div>
</footer>

@endsection