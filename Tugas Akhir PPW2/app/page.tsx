import { Button } from "@/components/ui/button"
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "@/components/ui/card"
import { Badge } from "@/components/ui/badge"
import { Train, MapPin, Clock, Star, Users, Shield } from "lucide-react"
import Image from "next/image"
import Link from "next/link"

export default function HomePage() {
  return (
    <div className="min-h-screen bg-gradient-to-b from-blue-50 to-white">
      {/* Header */}
      <header className="bg-white shadow-sm border-b">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between items-center h-16">
            <div className="flex items-center space-x-2">
              <Train className="h-8 w-8 text-blue-600" />
              <span className="text-2xl font-bold text-gray-900">Gu-Book KAI</span>
            </div>

            <nav className="hidden md:flex space-x-8">
              <Link href="/" className="text-blue-600 font-medium">
                Beranda
              </Link>
              <Link href="/routes" className="text-gray-600 hover:text-blue-600">
                Pelayanan Rute
              </Link>
              <Link href="/tickets" className="text-gray-600 hover:text-blue-600">
                Pesan Tiket
              </Link>
              <Link href="/facilities" className="text-gray-600 hover:text-blue-600">
                Fasilitas Kereta
              </Link>
              <Link href="/news" className="text-gray-600 hover:text-blue-600">
                Apa yang Baru
              </Link>
            </nav>

            <div className="flex items-center space-x-4">
              <Button variant="outline">Login</Button>
              <Button>Sign Up</Button>
            </div>
          </div>
        </div>
      </header>

      {/* Hero Section */}
      <section className="relative py-20 px-4 sm:px-6 lg:px-8">
        <div className="max-w-7xl mx-auto">
          <div className="text-center mb-12">
            <h1 className="text-4xl md:text-6xl font-bold text-gray-900 mb-6">KEMEWAHAN NAN ELEGAN</h1>
            <p className="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
              Panduan lengkap perkeretaapian Indonesia - Temukan informasi rute, harga, kelas, dan fasilitas kereta api
              terlengkap
            </p>
            <div className="flex flex-col sm:flex-row gap-4 justify-center">
              <Button size="lg" className="bg-blue-600 hover:bg-blue-700">
                <MapPin className="mr-2 h-5 w-5" />
                Cari Rute Kereta
              </Button>
              <Button size="lg" variant="outline">
                <Clock className="mr-2 h-5 w-5" />
                Jadwal Keberangkatan
              </Button>
            </div>
          </div>

          {/* Hero Image */}
          <div className="relative rounded-2xl overflow-hidden shadow-2xl">
            <Image
              src="/images/train-hero.png"
              alt="Kereta Api Indonesia - Luxury Train"
              width={1200}
              height={600}
              className="w-full h-[400px] md:h-[600px] object-cover"
            />
            <div className="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent" />
            <div className="absolute bottom-8 left-8 text-white">
              <h3 className="text-2xl font-bold mb-2">Perjalanan Berkelas Premium</h3>
              <p className="text-lg opacity-90">Nikmati kenyamanan dan kemewahan dalam setiap perjalanan</p>
            </div>
          </div>
        </div>
      </section>

      {/* Train Classes Section */}
      <section className="py-16 px-4 sm:px-6 lg:px-8 bg-gray-50">
        <div className="max-w-7xl mx-auto">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-gray-900 mb-4">Kelas Perjalanan</h2>
            <p className="text-lg text-gray-600">Pilih kelas yang sesuai dengan kebutuhan perjalanan Anda</p>
          </div>

          <div className="grid md:grid-cols-3 gap-8">
            <Card className="hover:shadow-lg transition-shadow">
              <CardHeader>
                <div className="flex items-center justify-between">
                  <CardTitle className="text-xl">Imperial Class</CardTitle>
                  <Badge className="bg-yellow-100 text-yellow-800">Premium</Badge>
                </div>
                <CardDescription>Kelas tertinggi dengan fasilitas mewah</CardDescription>
              </CardHeader>
              <CardContent>
                <div className="space-y-3">
                  <div className="flex items-center text-sm text-gray-600">
                    <Star className="h-4 w-4 mr-2 text-yellow-500" />
                    Kursi reclining premium
                  </div>
                  <div className="flex items-center text-sm text-gray-600">
                    <Users className="h-4 w-4 mr-2 text-blue-500" />
                    Kapasitas terbatas
                  </div>
                  <div className="flex items-center text-sm text-gray-600">
                    <Shield className="h-4 w-4 mr-2 text-green-500" />
                    Layanan premium
                  </div>
                </div>
              </CardContent>
            </Card>

            <Card className="hover:shadow-lg transition-shadow">
              <CardHeader>
                <div className="flex items-center justify-between">
                  <CardTitle className="text-xl">Priority Class</CardTitle>
                  <Badge className="bg-blue-100 text-blue-800">Populer</Badge>
                </div>
                <CardDescription>Kenyamanan optimal dengan harga terjangkau</CardDescription>
              </CardHeader>
              <CardContent>
                <div className="space-y-3">
                  <div className="flex items-center text-sm text-gray-600">
                    <Star className="h-4 w-4 mr-2 text-yellow-500" />
                    Kursi nyaman dengan AC
                  </div>
                  <div className="flex items-center text-sm text-gray-600">
                    <Users className="h-4 w-4 mr-2 text-blue-500" />
                    Kapasitas sedang
                  </div>
                  <div className="flex items-center text-sm text-gray-600">
                    <Shield className="h-4 w-4 mr-2 text-green-500" />
                    Layanan standar
                  </div>
                </div>
              </CardContent>
            </Card>

            <Card className="hover:shadow-lg transition-shadow">
              <CardHeader>
                <div className="flex items-center justify-between">
                  <CardTitle className="text-xl">Retro Dine-In</CardTitle>
                  <Badge className="bg-orange-100 text-orange-800">Unik</Badge>
                </div>
                <CardDescription>Pengalaman kuliner dalam perjalanan</CardDescription>
              </CardHeader>
              <CardContent>
                <div className="space-y-3">
                  <div className="flex items-center text-sm text-gray-600">
                    <Star className="h-4 w-4 mr-2 text-yellow-500" />
                    Restoran dalam kereta
                  </div>
                  <div className="flex items-center text-sm text-gray-600">
                    <Users className="h-4 w-4 mr-2 text-blue-500" />
                    Pengalaman berkuliner
                  </div>
                  <div className="flex items-center text-sm text-gray-600">
                    <Shield className="h-4 w-4 mr-2 text-green-500" />
                    Menu spesial
                  </div>
                </div>
              </CardContent>
            </Card>
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section className="py-16 px-4 sm:px-6 lg:px-8">
        <div className="max-w-7xl mx-auto">
          <div className="text-center mb-12">
            <h2 className="text-3xl font-bold text-gray-900 mb-4">Mengapa Memilih Gu-Book KAI?</h2>
            <p className="text-lg text-gray-600">Platform terlengkap untuk informasi perkeretaapian Indonesia</p>
          </div>

          <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div className="text-center">
              <div className="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <MapPin className="h-8 w-8 text-blue-600" />
              </div>
              <h3 className="text-xl font-semibold mb-2">Rute Lengkap</h3>
              <p className="text-gray-600">Informasi rute kereta api seluruh Indonesia dengan detail pemberhentian</p>
            </div>

            <div className="text-center">
              <div className="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <Clock className="h-8 w-8 text-green-600" />
              </div>
              <h3 className="text-xl font-semibold mb-2">Jadwal Akurat</h3>
              <p className="text-gray-600">Jadwal keberangkatan dan kedatangan yang selalu terupdate</p>
            </div>

            <div className="text-center">
              <div className="bg-yellow-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <Star className="h-8 w-8 text-yellow-600" />
              </div>
              <h3 className="text-xl font-semibold mb-2">Harga Terbaik</h3>
              <p className="text-gray-600">Informasi tarif terlengkap dengan harga khusus untuk member</p>
            </div>

            <div className="text-center">
              <div className="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <Shield className="h-8 w-8 text-purple-600" />
              </div>
              <h3 className="text-xl font-semibold mb-2">Terpercaya</h3>
              <p className="text-gray-600">Data resmi dari PT Kereta Api Indonesia yang selalu terupdate</p>
            </div>
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-16 px-4 sm:px-6 lg:px-8 bg-blue-600">
        <div className="max-w-4xl mx-auto text-center">
          <h2 className="text-3xl font-bold text-white mb-4">Mulai Perjalanan Anda Sekarang</h2>
          <p className="text-xl text-blue-100 mb-8">
            Daftar sekarang dan dapatkan akses ke tarif khusus serta fitur premium lainnya
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Button size="lg" className="bg-white text-blue-600 hover:bg-gray-100">
              Daftar Gratis
            </Button>
            <Button size="lg" variant="outline" className="border-white text-white hover:bg-white hover:text-blue-600">
              Pelajari Lebih Lanjut
            </Button>
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer className="bg-gray-900 text-white py-12 px-4 sm:px-6 lg:px-8">
        <div className="max-w-7xl mx-auto">
          <div className="grid md:grid-cols-4 gap-8">
            <div>
              <div className="flex items-center space-x-2 mb-4">
                <Train className="h-8 w-8 text-blue-400" />
                <span className="text-2xl font-bold">Gu-Book KAI</span>
              </div>
              <p className="text-gray-400">
                Panduan terlengkap perkeretaapian Indonesia untuk perjalanan yang nyaman dan aman.
              </p>
            </div>

            <div>
              <h3 className="text-lg font-semibold mb-4">Informasi</h3>
              <ul className="space-y-2 text-gray-400">
                <li>
                  <Link href="/about" className="hover:text-white">
                    Tentang Kami
                  </Link>
                </li>
                <li>
                  <Link href="/faq" className="hover:text-white">
                    FAQ
                  </Link>
                </li>
                <li>
                  <Link href="/contact" className="hover:text-white">
                    Kontak
                  </Link>
                </li>
                <li>
                  <Link href="/terms" className="hover:text-white">
                    Syarat dan Ketentuan
                  </Link>
                </li>
              </ul>
            </div>

            <div>
              <h3 className="text-lg font-semibold mb-4">Layanan</h3>
              <ul className="space-y-2 text-gray-400">
                <li>
                  <Link href="/routes" className="hover:text-white">
                    Pencarian Rute
                  </Link>
                </li>
                <li>
                  <Link href="/schedule" className="hover:text-white">
                    Jadwal Kereta
                  </Link>
                </li>
                <li>
                  <Link href="/prices" className="hover:text-white">
                    Informasi Tarif
                  </Link>
                </li>
                <li>
                  <Link href="/facilities" className="hover:text-white">
                    Fasilitas
                  </Link>
                </li>
              </ul>
            </div>

            <div>
              <h3 className="text-lg font-semibold mb-4">Media Sosial</h3>
              <ul className="space-y-2 text-gray-400">
                <li>
                  <Link href="#" className="hover:text-white">
                    Facebook
                  </Link>
                </li>
                <li>
                  <Link href="#" className="hover:text-white">
                    Instagram
                  </Link>
                </li>
                <li>
                  <Link href="#" className="hover:text-white">
                    Twitter
                  </Link>
                </li>
                <li>
                  <Link href="#" className="hover:text-white">
                    YouTube
                  </Link>
                </li>
              </ul>
            </div>
          </div>

          <div className="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; 2024 Gu-Book KAI. Semua hak dilindungi undang-undang.</p>
          </div>
        </div>
      </footer>
    </div>
  )
}
