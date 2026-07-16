<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>POS Kasir — Fenrir</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Playfair+Display:ital,wght@0,400;0,700;1,700&display=swap" rel="stylesheet">
    
    @if(isset($products[0]) && $products[0]->gambar)
    <link rel="preload" as="image" href="{{ asset('storage/' . $products[0]->gambar) }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .branding-font { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body class="bg-gray-100 h-screen overflow-hidden text-[#111]" x-data="kasirApp()">
    <div class="flex h-full">
        {{-- Left Side: Products --}}
        <div class="flex-1 flex flex-col h-full bg-gray-50 border-r border-gray-200">
            {{-- Header --}}
            <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between shadow-sm z-10">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 bg-[#111] rounded-xl flex items-center justify-center text-white font-black text-xl branding-font italic">F</div>
                    <div>
                        <h1 class="font-bold text-lg leading-tight">Fenrir Point of Sale</h1>
                        <p class="text-xs text-gray-500">Kasir: {{ auth()->user()->name }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    @role('super_admin')
                    <a href="{{ url('/admin') }}" class="text-sm font-medium text-gray-600 hover:text-[#FA5400] transition-colors">Dasbor Admin</a>
                    @endrole
                    <a href="{{ url('/') }}" class="text-sm font-medium text-gray-600 hover:text-[#FA5400] transition-colors">Ke Toko</a>
                </div>
            </header>

            {{-- Search & Filter --}}
            <div class="p-6 pb-0 flex gap-4">
                <div class="relative flex-1">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <input type="text" x-model="search" placeholder="Cari nama atau merk sepatu..." class="w-full pl-10 pr-4 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#FA5400] focus:border-[#FA5400] transition-all bg-white shadow-sm">
                </div>
                <select x-model="kategori" class="py-3 px-4 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#FA5400] focus:border-[#FA5400] bg-white shadow-sm font-medium">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Product Grid (Server Side Rendered for LCP & CLS) --}}
            <div class="flex-1 overflow-y-auto p-6">
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                    @foreach($products as $index => $product)
                        <div x-show="isProductVisible({{ $product->id }})" 
                             @click="addToCart(products.find(p => p.id === {{ $product->id }}))" 
                             class="bg-white rounded-2xl p-3 border border-gray-100 shadow-sm hover:shadow-md hover:border-[#FA5400] cursor-pointer transition-all group flex flex-col relative overflow-hidden">
                            
                            <div class="bg-gray-50 rounded-xl aspect-square mb-3 flex items-center justify-center p-2 relative">
                                @if($product->gambar)
                                <img src="{{ asset('storage/' . $product->gambar) }}" alt="{{ $product->nama }}" 
                                     loading="{{ $index < 4 ? 'eager' : 'lazy' }}"
                                     fetchpriority="{{ $index < 4 ? 'high' : 'auto' }}"
                                     decoding="async"
                                     class="w-full h-full object-contain mix-blend-multiply group-hover:scale-110 transition-transform duration-300">
                                @endif
                                <div class="absolute top-2 left-2 bg-[#111] text-white text-[10px] font-bold px-2 py-0.5 rounded-full" x-text="getProductStock({{ $product->id }}) + ' Stok'"></div>
                            </div>
                            <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider">{{ $product->merk?->nama }}</p>
                            <h3 class="font-semibold text-sm leading-tight mb-1 line-clamp-1 group-hover:text-[#FA5400]">{{ $product->nama }}</h3>
                            <div class="mt-auto flex items-center justify-between">
                                <p class="font-black text-sm">Rp {{ number_format($product->harga, 0, ',', '.') }}</p>
                                <div class="w-6 h-6 rounded-full bg-gray-100 group-hover:bg-[#FA5400] group-hover:text-white flex items-center justify-center transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div x-show="!hasVisibleProducts()" class="col-span-full py-12 text-center" style="display: none;">
                        <p class="text-gray-500 font-medium">Tidak ada produk yang ditemukan.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Side: Cart --}}
        <div class="w-96 bg-white shadow-[-10px_0_20px_rgba(0,0,0,0.03)] flex flex-col h-full z-20">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-xl font-black">Keranjang</h2>
                <p class="text-xs text-gray-500 mt-1"><span x-text="cartItemCount()"></span> barang dipilih</p>
            </div>

            {{-- Cart Items --}}
            <div class="flex-1 overflow-y-auto p-6 space-y-4">
                <template x-for="(item, index) in cart" :key="item.id">
                    <div class="flex gap-3">
                        <div class="w-16 h-16 rounded-xl bg-gray-50 border border-gray-100 flex-shrink-0 p-1">
                            <img :src="'/storage/' + item.gambar" class="w-full h-full object-contain mix-blend-multiply">
                        </div>
                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-sm line-clamp-1" x-text="item.nama"></h4>
                            <p class="font-bold text-[#FA5400] text-sm" x-text="formatPrice(item.harga)"></p>
                            <div class="flex items-center gap-3 mt-2">
                                <div class="flex items-center bg-gray-100 rounded-lg">
                                    <button @click="updateQty(index, -1)" class="w-7 h-7 flex items-center justify-center hover:bg-gray-200 rounded-l-lg transition-colors">-</button>
                                    <span class="w-8 text-center text-sm font-medium" x-text="item.qty"></span>
                                    <button @click="updateQty(index, 1)" class="w-7 h-7 flex items-center justify-center hover:bg-gray-200 rounded-r-lg transition-colors">+</button>
                                </div>
                                <button @click="removeFromCart(index)" class="text-red-500 hover:text-red-600 text-xs font-semibold p-1">Hapus</button>
                            </div>
                        </div>
                    </div>
                </template>
                <div x-show="cart.length === 0" class="h-full flex flex-col items-center justify-center opacity-50 py-10">
                    <svg class="w-16 h-16 mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    <p class="text-sm font-medium">Keranjang masih kosong</p>
                </div>
            </div>

            {{-- Checkout Form --}}
            <div class="p-6 bg-gray-50 border-t border-gray-200">
                <div class="space-y-3 mb-6">
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Nama Pelanggan (Opsional)</label>
                        <input type="text" x-model="customerName" placeholder="Umum" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:ring-[#FA5400] focus:border-[#FA5400]">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 mb-1">Metode Pembayaran</label>
                        <select x-model="paymentMethod" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:ring-[#FA5400] focus:border-[#FA5400] font-medium">
                            <option value="tunai">Tunai</option>
                            <option value="qris">QRIS</option>
                            <option value="transfer">Transfer Bank</option>
                            <option value="kartu_debit">Kartu Debit</option>
                            <option value="kartu_kredit">Kartu Kredit</option>
                        </select>
                    </div>
                </div>

                <div class="flex items-end justify-between mb-4">
                    <span class="text-gray-500 font-medium text-sm">Total Tagihan</span>
                    <span class="text-2xl font-black text-[#111]" x-text="formatPrice(cartTotal())"></span>
                </div>
                
                <button 
                    @click="processCheckout" 
                    :disabled="cart.length === 0 || isProcessing"
                    class="w-full bg-[#111] text-white font-bold py-4 rounded-xl hover:bg-[#FA5400] transition-all disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2"
                >
                    <span x-show="!isProcessing">Proses Pembayaran</span>
                    <span x-show="isProcessing">Memproses...</span>
                    <svg x-show="!isProcessing" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Success Modal --}}
    <div x-show="showSuccess" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4" style="display: none;">
        <div class="bg-white rounded-3xl p-8 max-w-sm w-full text-center shadow-2xl relative" @click.away="resetCart()">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 text-green-500">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
            </div>
            <h3 class="text-2xl font-black mb-2">Pembayaran Berhasil!</h3>
            <p class="text-gray-500 text-sm mb-1">Invoice: <span class="font-bold text-black" x-text="lastInvoice"></span></p>
            <p class="text-gray-500 text-sm mb-6">Total: <span class="font-bold text-black" x-text="formatPrice(lastTotal)"></span></p>
            
            <div class="flex gap-3">
                <button class="flex-1 border border-gray-200 font-bold py-3 rounded-xl hover:bg-gray-50 transition-colors">Cetak Struk</button>
                <button @click="resetCart()" class="flex-1 bg-[#111] text-white font-bold py-3 rounded-xl hover:bg-[#FA5400] transition-colors">Transaksi Baru</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('kasirApp', () => ({
                products: @json($products),
                filteredProducts: @json($products),
                cart: [],
                search: '',
                kategori: '',
                customerName: 'Umum',
                paymentMethod: 'tunai',
                isProcessing: false,
                showSuccess: false,
                lastInvoice: '',
                lastTotal: 0,

                isProductVisible(id) {
                    let p = this.products.find(prod => prod.id === id);
                    if (!p || p.stok <= 0) return false;
                    let term = this.search.toLowerCase();
                    let matchSearch = p.nama.toLowerCase().includes(term) || p.merk.toLowerCase().includes(term);
                    let matchKat = this.kategori === '' || p.kategori === this.kategori;
                    return matchSearch && matchKat;
                },

                hasVisibleProducts() {
                    return this.products.some(p => this.isProductVisible(p.id));
                },

                getProductStock(id) {
                    let p = this.products.find(prod => prod.id === id);
                    return p ? p.stok : 0;
                },

                addToCart(product) {
                    let existing = this.cart.find(i => i.id === product.id);
                    if (existing) {
                        if (existing.qty < product.stok) {
                            existing.qty++;
                        } else {
                            alert('Stok tidak mencukupi!');
                        }
                    } else {
                        this.cart.push({ ...product, qty: 1 });
                    }
                },

                updateQty(index, change) {
                    let item = this.cart[index];
                    let newQty = item.qty + change;
                    if (newQty > 0) {
                        let product = this.products.find(p => p.id === item.id);
                        if (newQty <= product.stok) {
                            item.qty = newQty;
                        } else {
                            alert('Stok tidak mencukupi!');
                        }
                    } else {
                        this.removeFromCart(index);
                    }
                },

                removeFromCart(index) {
                    this.cart.splice(index, 1);
                },

                cartItemCount() {
                    return this.cart.reduce((total, item) => total + item.qty, 0);
                },

                cartTotal() {
                    return this.cart.reduce((total, item) => total + (item.harga * item.qty), 0);
                },

                formatPrice(price) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(price);
                },

                async processCheckout() {
                    if (this.cart.length === 0) return;
                    
                    this.isProcessing = true;
                    
                    try {
                        const response = await fetch('{{ url('/kasir/process') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                nama_pelanggan: this.customerName || 'Umum',
                                metode_pembayaran: this.paymentMethod,
                                items: this.cart.map(i => ({ id: i.id, qty: i.qty }))
                            })
                        });
                        
                        const data = await response.json();
                        
                        if (data.success) {
                            this.lastInvoice = data.invoice;
                            this.lastTotal = data.total;
                            this.showSuccess = true;
                            
                            // Update local stock silently
                            this.cart.forEach(cartItem => {
                                let prod = this.products.find(p => p.id === cartItem.id);
                                if(prod) prod.stok -= cartItem.qty;
                            });
                            // Remove items with 0 stock
                            this.products = this.products.filter(p => p.stok > 0);
                            this.filterProducts();
                        } else {
                            alert('Gagal: ' + data.message);
                        }
                    } catch (error) {
                        alert('Terjadi kesalahan sistem.');
                    } finally {
                        this.isProcessing = false;
                    }
                },
                
                resetCart() {
                    this.cart = [];
                    this.customerName = 'Umum';
                    this.paymentMethod = 'tunai';
                    this.showSuccess = false;
                }
            }));
        });
    </script>
</body>
</html>
