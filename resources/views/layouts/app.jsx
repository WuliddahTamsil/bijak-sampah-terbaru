import React, { useState } from 'react';
import {
  HomeIcon,
  GiftIcon,
  ShoppingBagIcon,
  ShoppingCartIcon,
  HeartIcon,
  ClockIcon,
  Cog6ToothIcon,
  ArrowRightOnRectangleIcon,
  Bars3Icon,
  BellIcon,
  MagnifyingGlassIcon,
} from '@heroicons/react/24/outline';

// Data menu untuk sidebar
const navItems = [
  { name: 'Dashboard', icon: HomeIcon, href: '#dashboard' },
  { name: 'Poin Mu', icon: GiftIcon, href: '#poin-mu' },
  { name: 'Marketplace', icon: ShoppingBagIcon, href: '#marketplace' },
  { name: 'Belanja', icon: ShoppingCartIcon, href: '#belanja' },
  { name: 'Wishlist', icon: HeartIcon, href: '#wishlist' },
  { name: 'Riwayat', icon: ClockIcon, href: '#riwayat' },
  { name: 'Settings', icon: Cog6ToothIcon, href: '#settings' },
];

// Komponen Sidebar
const Sidebar = ({ isOpen, activeItem, setActiveItem }) => {
  const sidebarClasses = `fixed inset-y-0 left-0 z-40 bg-gradient-to-br from-green-400 to-blue-500 text-white transition-transform duration-300 transform md:translate-x-0 ${
    isOpen ? 'translate-x-0 w-[250px]' : '-translate-x-full w-[250px]'
  }`;

  return (
    <aside className={sidebarClasses}>
      <div className="flex flex-col h-full py-6 px-4">
        <div className="flex items-center justify-center mb-8 mt-2">
          <h1 className="text-3xl font-bold">Logo</h1>
        </div>
        <nav className="flex-1 space-y-2">
          {navItems.map((item) => (
            <a
              key={item.name}
              href={item.href}
              onClick={() => setActiveItem(item.name)}
              className={`flex items-center gap-3 p-3 font-medium whitespace-nowrap w-full rounded-lg transition-colors duration-200 ${
                activeItem === item.name
                  ? 'bg-white bg-opacity-20 shadow-sm'
                  : 'hover:bg-white hover:bg-opacity-10'
              }`}
            >
              <item.icon className="w-6 h-6 flex-shrink-0" />
              <span className="text-sm">{item.name}</span>
            </a>
          ))}
        </nav>
        <div className="mt-auto pt-4 border-t border-white border-opacity-20">
          <a
            href="#logout"
            className="flex items-center gap-3 p-3 rounded-lg hover:bg-white hover:bg-opacity-10 text-white transition-colors duration-200"
          >
            <ArrowRightOnRectangleIcon className="w-6 h-6 flex-shrink-0" />
            <span className="text-sm">Logout</span>
          </a>
        </div>
      </div>
    </aside>
  );
};

// Komponen TopBar
const TopBar = ({ toggleSidebar }) => {
  return (
    <header className="fixed top-0 left-0 right-0 z-30 bg-white shadow-sm transition-all duration-300 md:pl-[250px] p-4 flex items-center justify-between">
      <div className="flex items-center gap-4 w-full md:w-auto">
        <button onClick={toggleSidebar} className="md:hidden">
          <Bars3Icon className="w-6 h-6 text-gray-700" />
        </button>
        <div className="relative flex-grow">
          <span className="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
            <MagnifyingGlassIcon className="w-5 h-5" />
          </span>
          <input
            type="text"
            placeholder="Cari..."
            className="w-full pl-10 pr-4 py-2 rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm"
          />
        </div>
      </div>
      <div className="flex items-center gap-4">
        <div className="relative">
          <BellIcon className="w-6 h-6 text-gray-600" />
          <span className="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
            3
          </span>
        </div>
        <img
          src="https://via.placeholder.com/40"
          alt="Avatar"
          className="w-10 h-10 rounded-full object-cover border-2 border-gray-300"
        />
      </div>
    </header>
  );
};

// Komponen Layout
const Layout = ({ children }) => {
  const [isSidebarOpen, setIsSidebarOpen] = useState(false);
  const [activeItem, setActiveItem] = useState('Dashboard');

  const toggleSidebar = () => {
    setIsSidebarOpen(!isSidebarOpen);
  };

  return (
    <div className="flex min-h-screen bg-gray-100">
      <Sidebar
        isOpen={isSidebarOpen}
        activeItem={activeItem}
        setActiveItem={setActiveItem}
      />
      <div className="flex-1 flex flex-col transition-all duration-300 md:pl-[250px]">
        <TopBar toggleSidebar={toggleSidebar} />
        <main className="flex-1 pt-20 p-6">
          {children}
        </main>
      </div>
    </div>
  );
};

// Komponen Aplikasi Utama
const App = () => {
  return (
    <Layout>
      <div className="p-6 bg-white rounded-lg shadow-md min-h-[80vh]">
        <h2 className="text-xl font-semibold text-gray-800">Konten Dashboard Non-Nasabah</h2>
        <p className="mt-4 text-gray-600">
          Di sini Anda dapat menempatkan widget, grafik, atau informasi lainnya untuk dashboard non-nasabah.
        </p>
      </div>
    </Layout>
  );
};

export default App;