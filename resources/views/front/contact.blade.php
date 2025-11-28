<x-app-layout>

    {{-- HERO SECTION --}}
    <section class="relative w-full h-72 bg-primary text-white flex items-center justify-center">

        <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary-700 to-primary-900 opacity-90"></div>

        <div class="relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-extrabold tracking-wide">
                Contactez-nous
            </h1>

            <p class="text-white/90 mt-4 text-lg max-w-xl mx-auto leading-relaxed">
                Une question ? Un besoin d’assistance ? Notre équipe vous accompagne dans tous vos projets immobiliers.
            </p>
        </div>
    </section>



    {{-- SECTION PRINCIPALE --}}
    <section class="py-20 bg-gray-50">

        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-2 gap-12">

            {{-- FORMULAIRE DE CONTACT --}}
            <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-200">

                <h2 class="text-2xl font-bold text-gray-900 mb-6">
                    Envoyer un message
                </h2>

                <form method="POST" action="{{ route('contact.send') }}">
                    @csrf

                    {{-- Champ duo --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-semibold text-gray-700">Prénom</label>
                            <input type="text" name="prenom" required
                                   class="w-full mt-1 px-4 py-3 rounded-lg border-gray-300 focus:ring-primary focus:border-primary" />
                        </div>

                        <div>
                            <label class="text-sm font-semibold text-gray-700">Nom</label>
                            <input type="text" name="nom" required
                                   class="w-full mt-1 px-4 py-3 rounded-lg border-gray-300 focus:ring-primary focus:border-primary" />
                        </div>
                    </div>

                    {{-- Email --}}
                    <div class="mt-4">
                        <label class="text-sm font-semibold text-gray-700">Email</label>
                        <input type="email" name="email" required
                               class="w-full mt-1 px-4 py-3 rounded-lg border-gray-300 focus:ring-primary focus:border-primary" />
                    </div>

                    {{-- Téléphone --}}
                    <div class="mt-4">
                        <label class="text-sm font-semibold text-gray-700">Téléphone</label>
                        <input type="text" name="telephone"
                               class="w-full mt-1 px-4 py-3 rounded-lg border-gray-300 focus:ring-primary focus:border-primary" />
                    </div>

                    {{-- Message --}}
                    <div class="mt-4">
                        <label class="text-sm font-semibold text-gray-700">Message</label>
                        <textarea name="message" rows="5" required
                                  class="w-full mt-1 px-4 py-3 rounded-lg border-gray-300 focus:ring-primary focus:border-primary"></textarea>
                    </div>

                    {{-- Bouton --}}
                    <button
                        class="mt-6 w-full bg-primary hover:bg-primary-700 text-white py-3 rounded-xl font-semibold text-lg shadow-lg transition">
                        Envoyer le message
                    </button>
                </form>
            </div>



            {{-- INFORMATIONS & GOOGLE MAP --}}
            <div class="flex flex-col gap-6">

                {{-- Informations de contact --}}
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-200">

                    <h2 class="text-2xl font-bold mb-6 text-gray-900">Nos coordonnées</h2>

                    <ul class="space-y-5 text-gray-700">

                        <li class="flex items-center space-x-4">
                            <i data-lucide="map-pin" class="h-7 w-7 text-primary"></i>
                            <p class="font-medium">Dakar, Sénégal</p>
                        </li>

                        <li class="flex items-center space-x-4">
                            <i data-lucide="mail" class="h-7 w-7 text-primary"></i>
                            <p class="font-medium">contact@bellyimmo.com</p>
                        </li>

                        <li class="flex items-center space-x-4">
                            <i data-lucide="phone-call" class="h-7 w-7 text-primary"></i>
                            <p class="font-medium">+221 78 665 28 94</p>
                        </li>

                        <li class="flex items-center space-x-4">
                            <i data-lucide="clock" class="h-7 w-7 text-primary"></i>
                            <p class="font-medium">Lun - Sam : 08h - 19h</p>
                        </li>

                    </ul>
                </div>


                {{-- Google Map --}}
                <div class="w-full h-64 rounded-2xl overflow-hidden shadow-lg border border-gray-200">
                    <iframe
                        width="100%"
                        height="100%"
                        frameborder="0"
                        allowfullscreen
                        style="border:0;"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d620896.7810881918!2d-17.64246755!3d14.695284549999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xec172d71a24e541%3A0xe8b1ea934d65e8f!2sDakar!5e0!3m2!1sfr!2ssn!4v1707059758292">
                    </iframe>
                </div>

            </div>

        </div>

    </section>



    {{-- CTA FINAL --}}
    <section class="py-20 bg-primary text-white text-center">

        <h2 class="text-3xl md:text-4xl font-extrabold">Besoin d’assistance ?</h2>

        <p class="text-white/90 mt-2">
            Notre équipe sera ravie de vous accompagner.
        </p>

        <a href="{{ route('home') }}"
           class="inline-block mt-6 bg-white text-primary px-8 py-3 rounded-xl font-semibold hover:bg-gray-100 shadow-lg">
            Retour à l'accueil
        </a>

    </section>

    <script>
        lucide.createIcons();
    </script>

</x-app-layout>
