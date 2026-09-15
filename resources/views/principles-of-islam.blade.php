@extends('main-layout')

@section('title', 'Basic Principles of Islam - Ipswich Mosque')
@section('description', 'Learn the fundamental principles of Islam including the Five Pillars, Six Articles of Faith, and other essential Islamic teachings.')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-amber-500 to-amber-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Basic Principles of Islam</h1>
            <p class="text-xl md:text-2xl opacity-90">Understanding the Foundation of Our Faith</p>
        </div>
    </div>

    <!-- Content Section -->
    <div class="container mx-auto px-4 py-12">
        <!-- Introduction -->
        <div class="max-w-4xl mx-auto mb-12">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Introduction</h2>
                <p class="text-gray-600 leading-relaxed mb-4">
                    Islam is built upon fundamental principles that guide every aspect of a Muslim's life. 
                    These principles provide the foundation for worship, ethics, and daily conduct. 
                    Understanding these basics is essential for every Muslim and those who wish to learn about Islam.
                </p>
            </div>
        </div>

        <!-- Five Pillars of Islam -->
        <div class="max-w-4xl mx-auto mb-12">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">The Five Pillars of Islam</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <!-- Shahadah -->
                    <div class="border-l-4 border-amber-500 pl-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">1. Shahadah (Faith)</h3>
                        <p class="text-gray-600">
                            The declaration of faith: "There is no god but Allah, and Muhammad is His Messenger."
                            This is the foundation of Islamic belief and the first words whispered to a newborn.
                        </p>
                    </div>

                    <!-- Salah -->
                    <div class="border-l-4 border-amber-500 pl-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">2. Salah (Prayer)</h3>
                        <p class="text-gray-600">
                            Performing the five daily prayers at their prescribed times. Prayer is the direct 
                            connection between the worshipper and Allah, performed facing the Kaaba in Makkah.
                        </p>
                    </div>

                    <!-- Zakah -->
                    <div class="border-l-4 border-amber-500 pl-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">3. Zakah (Charity)</h3>
                        <p class="text-gray-600">
                            Obligatory charity (2.5% of savings) given annually to help the poor and needy.
                            It purifies wealth and fosters social responsibility.
                        </p>
                    </div>

                    <!-- Sawm -->
                    <div class="border-l-4 border-amber-500 pl-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">4. Sawm (Fasting)</h3>
                        <p class="text-gray-600">
                            Fasting during the month of Ramadan from dawn to sunset. It teaches self-discipline,
                            patience, and empathy for those less fortunate.
                        </p>
                    </div>

                    <!-- Hajj -->
                    <div class="border-l-4 border-amber-500 pl-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">5. Hajj (Pilgrimage)</h3>
                        <p class="text-gray-600">
                            The pilgrimage to Makkah, obligatory once in a lifetime for those who are able.
                            It occurs during the Islamic month of Dhul Hijjah.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Six Articles of Faith -->
        <div class="max-w-4xl mx-auto mb-12">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">The Six Articles of Faith</h2>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="border-l-4 border-green-500 pl-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">1. Belief in Allah</h3>
                        <p class="text-gray-600">
                            Belief in the Oneness of Allah (Tawhid) - He has no partners, no equals, 
                            and nothing is like unto Him.
                        </p>
                    </div>

                    <div class="border-l-4 border-green-500 pl-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">2. Belief in Angels</h3>
                        <p class="text-gray-600">
                            Belief in the existence of angels, including Jibreel (Gabriel), Mika'il, 
                            Israfil, and others who carry out Allah's commands.
                        </p>
                    </div>

                    <div class="border-l-4 border-green-500 pl-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">3. Belief in Books</h3>
                        <p class="text-gray-600">
                            Belief in all revealed scriptures: the Torah, Psalms, Gospel, and the Quran 
                            as the final and complete revelation.
                        </p>
                    </div>

                    <div class="border-l-4 border-green-500 pl-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">4. Belief in Prophets</h3>
                        <p class="text-gray-600">
                            Belief in all prophets from Adam to Muhammad (peace be upon them all), 
                            with Muhammad being the final messenger.
                        </p>
                    </div>

                    <div class="border-l-4 border-green-500 pl-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">5. Belief in Day of Judgment</h3>
                        <p class="text-gray-600">
                            Belief in the Day of Resurrection when all will be held accountable for 
                            their deeds and rewarded or punished accordingly.
                        </p>
                    </div>

                    <div class="border-l-4 border-green-500 pl-4">
                        <h3 class="text-xl font-semibold text-gray-800 mb-2">6. Belief in Divine Decree</h3>
                        <p class="text-gray-600">
                            Belief that Allah has knowledge of all things and that nothing happens 
                            except by His will and decree (Al-Qadr).
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Resources -->
        <div class="max-w-4xl mx-auto mb-12">
            <div class="bg-white rounded-lg shadow-md p-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-6">Additional Resources</h2>
                <div class="grid md:grid-cols-3 gap-4">
                    <a href="{{ url('/khutbah') }}" class="block p-4 bg-green-50 rounded-lg hover:bg-green-100 transition">
                        <h4 class="font-semibold text-green-800 mb-1">Khutbah Archive</h4>
                        <p class="text-sm text-green-600">Friday sermons and teachings</p>
                    </a>
                    <a href="{{ url('/duas') }}" class="block p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition">
                        <h4 class="font-semibold text-blue-800 mb-1">Daily Duas</h4>
                        <p class="text-sm text-blue-600">Supplications for daily life</p>
                    </a>
                    <a href="{{ url('/prayer-times') }}" class="block p-4 bg-amber-50 rounded-lg hover:bg-amber-100 transition">
                        <h4 class="font-semibold text-amber-800 mb-1">Prayer Times</h4>
                        <p class="text-sm text-amber-600">Daily prayer schedule</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Contact/CTA -->
        <div class="max-w-4xl mx-auto">
            <div class="bg-gradient-to-r from-amber-500 to-amber-600 rounded-lg shadow-md p-8 text-center text-white">
                <h2 class="text-2xl font-bold mb-4">Want to Learn More?</h2>
                <p class="mb-6 opacity-90">
                    Join us for educational programs, classes, and discussions about Islam.
                </p>
                <a href="{{ url('/contact') }}" class="inline-block bg-white text-amber-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                    Contact Us
                </a>
            </div>
        </div>
    </div>
</div>
@endsection