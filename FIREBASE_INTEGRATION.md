# Firebase Integration untuk Bank Sampah

## Overview
Sistem ini mengintegrasikan Firebase Realtime Database dengan dashboard bank sampah untuk memberikan notifikasi real-time dan grafik analitik berdasarkan data status tempat sampah.

## Fitur Utama

### 1. Real-time Notifications
- **Toast Notifications**: Muncul otomatis ketika ada perubahan status
- **Priority System**: 
  - 🔴 HIGH: Status "PENUH" 
  - 🟠 MEDIUM: Status "HAMPIR PENUH"
  - 🟢 LOW: Status lainnya
- **Sound Alerts**: Notifikasi suara untuk status penting
- **Auto-dismiss**: Notifikasi hilang otomatis setelah 5 detik

### 2. Real-time Charts
- **Status Chart**: Doughnut chart menunjukkan distribusi status
- **Nasabah Activity Chart**: Bar chart aktivitas update per nasabah
- **Time Series Chart**: Line chart perubahan status over time

### 3. Firebase Status Monitor
- Indikator koneksi Firebase real-time
- Auto-reconnect saat koneksi terputus

## Struktur Data Firebase

```json
{
  "UsersData": {
    "Nasabah1": {
      "status": "TEMPAT SAMPAH PENUH",
      "timestamp": "09-08-2025 13:51"
    },
    "Nasabah2": {
      "status": "HAMPIR PENUH",
      "timestamp": "09-08-2025 14:30"
    }
  }
}
```

## Cara Kerja

### 1. Data Flow
1. **Firebase Realtime Database** → Data status tempat sampah
2. **Firebase Listener** → Mendengarkan perubahan data
3. **Data Processing** → Memproses data untuk notifikasi dan grafik
4. **UI Update** → Update notifikasi dan grafik secara real-time

### 2. Notification System
- Mendeteksi perubahan status dari Firebase
- Membuat notifikasi berdasarkan prioritas
- Menampilkan toast notification
- Memainkan suara alert
- Update notification cards di dashboard

### 3. Chart System
- Mengumpulkan data historis dari Firebase
- Memproses data untuk berbagai jenis grafik
- Update grafik secara real-time
- Export data ke JSON

## Konfigurasi

### Firebase Config
```javascript
const firebaseConfig = {
    apiKey: "AIzaSyAJhkCyNT0be2x6FSzyUz0Ye9xX-QihIBo",
    authDomain: "bijaksampah-aeb82.firebaseapp.com",
    databaseURL: "https://bijaksampah-aeb82-default-rtdb.asia-southeast1.firebasedatabase.app",
    projectId: "bijaksampah-aeb82",
    storageBucket: "bijaksampah-aeb82.firebasestorage.app",
    messagingSenderId: "140467230562",
    appId: "1:140467230562:web:19a34dfefcb6f65bd7fe3b"
};
```

### Dependencies
- Firebase SDK 9.22.0
- Chart.js dengan date-fns adapter
- Alpine.js untuk UI interactions

## File Structure

```
public/asset/
├── js/
│   ├── firebase-config.js          # Konfigurasi Firebase
│   ├── firebase-notifications.js   # Sistem notifikasi
│   └── firebase-charts.js          # Sistem grafik
└── css/
    └── firebase-notifications.css  # Styling notifikasi

resources/views/
└── dashboard-banksampah.blade.php  # Dashboard dengan Firebase integration
```

## Cara Penggunaan

### 1. Setup Firebase
1. Pastikan project Firebase sudah dibuat
2. Update `firebaseConfig` dengan credentials yang benar
3. Pastikan Realtime Database sudah diaktifkan

### 2. Test Notifications
1. Update data di Firebase Realtime Database
2. Lihat notifikasi muncul otomatis
3. Check dashboard untuk notification cards

### 3. View Charts
1. Buka dashboard bank sampah
2. Scroll ke bagian "Firebase Real-time Analytics"
3. Lihat grafik update secara real-time

## Troubleshooting

### 1. Firebase Connection Issues
- Check internet connection
- Verify Firebase credentials
- Check browser console untuk error messages

### 2. Charts Not Loading
- Pastikan Chart.js sudah dimuat
- Check browser console untuk JavaScript errors
- Verify canvas elements ada di HTML

### 3. Notifications Not Working
- Check Firebase permissions
- Verify data structure di Firebase
- Check browser console untuk errors

## Security Considerations

⚠️ **PENTING**: Saat ini Firebase security rules belum dikonfigurasi dengan aman. Untuk production:

1. **Update Security Rules**:
```json
{
  "rules": {
    "UsersData": {
      ".read": "auth != null",
      ".write": "auth != null"
    }
  }
}
```

2. **Enable Authentication** untuk mengontrol akses
3. **Implement App Check** untuk mencegah abuse

## Future Enhancements

1. **Push Notifications** untuk mobile
2. **Email Alerts** untuk status kritis
3. **SMS Notifications** untuk urgent cases
4. **Advanced Analytics** dengan machine learning
5. **Predictive Maintenance** berdasarkan patterns

## Support

Untuk bantuan teknis atau pertanyaan:
- Check browser console untuk error logs
- Verify Firebase console untuk data flow
- Review network tab untuk connection issues

---

**Dibuat oleh**: AI Assistant  
**Versi**: 1.0.0  
**Tanggal**: 09-08-2025
