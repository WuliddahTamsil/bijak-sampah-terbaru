@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    /* Reset and Base Styles */
    html, body { 
        overflow-x: hidden; 
        margin: 0;
        padding: 0;
        scroll-behavior: smooth;
    }
    
    /* Sidebar Styles */
    .sidebar-gradient { 
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%); 
    }
    
    .sidebar-hover { 
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
    }
    
    .sidebar-item-hover { 
        transition: all 0.2s ease-in-out; 
    }
    
    .sidebar-item-hover:hover { 
        background-color: rgba(255, 255, 255, 0.2); 
    }
    
    .sidebar-logo { 
        transition: all 0.3s ease-in-out; 
    }
    
    .sidebar-nav-item { 
        transition: all 0.2s ease-in-out; 
        border-radius: 8px; 
    }
    
    .sidebar-nav-item:hover { 
        background-color: rgba(255, 255, 255, 0.1); 
    }
    
    .sidebar-nav-item.active { 
        background-color: rgba(255, 255, 255, 0.2); 
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
    }
    
    /* Status Filter Button Styles */
    .status-filter-section .filter-btn {
        transition: all 0.3s ease;
        border: none;
        font-weight: 500;
        cursor: pointer;
    }
    
    .status-filter-section .filter-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    
    .status-filter-section .filter-btn.active {
        transform: scale(1.05);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    
    /* Header Styles */
    .fixed-header {
        position: fixed; 
        top: 0; 
        left: 0; 
        right: 0; 
        height: 48px; 
        z-index: 40;
        display: flex; 
        align-items: center; 
        justify-content: space-between; 
        padding: 0 1.5rem; 
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%);
        transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    /* Main Content Layout */
    .main-content-wrapper {
        min-height: 100vh;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%, #f1f5f9 100%);
        padding-top: 30px; 
        padding-left: 2rem; 
        padding-right: 0;
        transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative; 
        overflow-x: hidden;
        width: 100%;
        scroll-behavior: smooth;
    }
    
    .content-container { 
        width: 100%; 
        margin: 0; 
        padding: 2rem; 
        position: relative; 
        z-index: 1; 
        box-sizing: border-box;
        scroll-behavior: smooth;
    }
    
    .sidebar-overlay {
        position: fixed; 
        top: 0; 
        left: 0; 
        width: 100%; 
        height: 100%;
        background: rgba(0, 0, 0, 0.5); 
        z-index: 45; 
        opacity: 0; 
        visibility: hidden;
        transition: all 0.3s ease;
    }
    
    .sidebar-overlay.active { 
        opacity: 1; 
        visibility: visible; 
    }
    
    /* Button Styles */
    .btn-primary {
        background: linear-gradient(135deg, #10B981, #059669);
        color: white;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
    }
    
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }
    
    .btn-secondary {
        background: linear-gradient(135deg, #05445E, #043a4e);
        color: white;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(5, 68, 94, 0.3);
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
    }
    
    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(5, 68, 94, 0.4);
    }

    /* BS Pay Section */
    .bs-pay-section {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
    }

    .bs-pay-card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 20px;
        transition: all 0.3s ease;
    }

    .bs-pay-card:first-child {
        flex: 1;
        background: linear-gradient(135deg, #f8f9fc 0%, #ffffff 100%);
        border: 1px solid #e0e6ed;
    }

    .bs-pay-card:nth-child(2) {
        flex: 3;
        padding: 0;
        overflow: hidden;
        background: linear-gradient(135deg, #f8f9fc 0%, #ffffff 100%);
        border: 1px solid #e0e6ed;
        justify-content: center;
    }

    .bs-pay-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }

    .bs-pay-logo {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        font-weight: bold;
        box-shadow: 0 4px 12px rgba(5, 68, 94, 0.2);
    }

    .bs-pay-info {
        flex: 1;
    }

    .bs-pay-title {
        font-size: 18px;
        color: #666;
        margin-bottom: 5px;
        font-weight: 600;
    }

    .bs-pay-amount {
        font-size: 32px;
        font-weight: 700;
        color: #05445E;
        margin-bottom: 10px;
    }

    .bs-pay-subtitle {
        font-size: 14px;
        color: #666;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .bs-pay-subtitle i {
        color: #4ADE80;
    }

    .pie-chart-container {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
        padding: 20px;
    }

    .pie-chart-container img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: all 0.3s ease;
    }

    .pie-chart-container:hover img {
        transform: scale(1.05);
    }

    /* Kategori Section */
    .kategori-section {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 22px;
        color: #0a3a60;
        font-weight: 700;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .section-title i {
        color: #05445E;
        font-size: 24px;
    }

    .kategori-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
    }

    .kategori-card {
        background: #f0f8ff;
        border-radius: 12px;
        padding: 20px;
        transition: all 0.3s;
        border-left: 4px solid #75E6DA;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .kategori-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    }

    .kategori-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 5px;
        background: linear-gradient(90deg, #75E6DA, #05445E);
    }

    .kategori-icon {
        font-size: 40px;
        color: #05445E;
        margin-bottom: 10px;
        transition: all 0.3s;
    }

    .kategori-card:hover .kategori-icon {
        transform: scale(1.1);
    }

    .kategori-berat {
        font-size: 18px;
        font-weight: 600;
        color: #05445E;
        margin-bottom: 5px;
    }

    .kategori-name {
        font-size: 16px;
        color: #333;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .kategori-total {
        font-size: 14px;
        color: #666;
        background: rgba(117, 230, 218, 0.2);
        padding: 4px 10px;
        border-radius: 20px;
    }

    /* Table Section */
    .table-section {
        background: white;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .filter-group {
        display: flex;
        gap: 15px;
        align-items: center;
        flex-wrap: wrap;
    }

    .filter-btn {
        background: white;
        border: 1px solid #ddd;
        padding: 8px 16px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
    }

    .filter-btn:hover {
        background: #f5f5f5;
    }

    .filter-btn.active {
        background: linear-gradient(135deg, #05445E 0%, #0A3A60 100%);
        color: white;
        border-color: #05445E;
    }

    .date-filter {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .date-input {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 14px;
        width: 150px;
        color: #333;
        background: white;
    }

    .date-picker-btn {
        position: absolute;
        right: 8px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #666;
        cursor: pointer;
        padding: 4px;
        border-radius: 4px;
        transition: all 0.2s;
    }

    .date-picker-btn:hover {
        background: #f0f0f0;
        color: #05445E;
    }

    .relative {
        position: relative;
    }

    .filter-buttons {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .dropdown-toggle {
        position: relative;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .month-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        background: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        z-index: 1000;
        min-width: 150px;
        display: none;
        max-height: 300px;
        overflow-y: auto;
    }

    .month-dropdown.show {
        display: block;
        animation: fadeInDown 0.2s ease-out;
    }

    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .month-option {
        padding: 10px 15px;
        cursor: pointer;
        transition: all 0.2s;
        border-bottom: 1px solid #f0f0f0;
    }

    .month-option:last-child {
        border-bottom: none;
    }

    .month-option:hover {
        background: #f8f9fc;
        color: #05445E;
    }

    /* Animasi untuk baris baru */
    .new-row {
        animation: highlightNewRow 0.5s ease-in-out;
    }

    @keyframes highlightNewRow {
        0% {
            background-color: #f0f9ff;
            transform: scale(1.02);
        }
        50% {
            background-color: #e0f2fe;
            transform: scale(1.01);
        }
        100% {
            background-color: #f0f9ff;
            transform: scale(1);
        }
    }

    /* Perbaikan untuk DataTables pagination */
    .dataTables_wrapper .dataTables_paginate .paginate_button.previous,
    .dataTables_wrapper .dataTables_paginate .paginate_button.next {
        background: linear-gradient(135deg, #05445E 0%, #0A3A60 100%) !important;
        color: white !important;
        border-color: #05445E !important;
        font-weight: 600;
        padding: 10px 16px;
        border-radius: 8px;
        margin: 0 5px;
        transition: all 0.3s ease;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.previous:hover,
    .dataTables_wrapper .dataTables_paginate .paginate_button.next:hover {
        background: linear-gradient(135deg, #0A3A60 0%, #05445E 100%) !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(5, 68, 94, 0.4);
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.previous:disabled,
    .dataTables_wrapper .dataTables_paginate .paginate_button.next:disabled {
        background: #e5e7eb !important;
        color: #9ca3af !important;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    /* DataTables Customization */
    #riwayatTable {
        width: 100% !important;
        border-collapse: separate;
        border-spacing: 0 10px;
    }

    #riwayatTable thead th {
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
        color: white;
        font-weight: 600;
        padding: 12px 15px;
        border: none;
        text-align: left;
    }

    #riwayatTable thead th:first-child {
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
    }

    #riwayatTable thead th:last-child {
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    #riwayatTable tbody tr {
        background: white;
        transition: all 0.3s;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border-radius: 8px;
    }

    #riwayatTable tbody tr:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    #riwayatTable tbody td {
        padding: 12px 15px;
        border: none;
        border-bottom: 1px solid #f0f0f0;
    }
    
    #riwayatTable tbody tr td:first-child {
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
    }
    
    #riwayatTable tbody tr td:last-child {
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    .action-btn {
        background: none;
        border: none;
        color: #05445E;
        cursor: pointer;
        font-size: 18px;
        padding: 5px;
        transition: all 0.2s;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .action-btn:hover {
        background: #f0f8ff;
        transform: scale(1.1);
        color: #0A3A60;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 8px 12px;
        border-radius: 8px;
        border: 1px solid #ddd;
        margin: 0 3px;
        transition: all 0.3s;
        color: #333 !important;
        background: white;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: linear-gradient(135deg, #05445E 0%, #0A3A60 100%) !important;
        color: white !important;
        border-color: #05445E !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: linear-gradient(135deg, #05445E 0%, #0A3A60 100%) !important;
        color: white !important;
        border-color: #05445E !important;
    }

    .dataTables_wrapper .dataTables_filter input {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-left: 10px;
    }

    .dataTables_wrapper .dataTables_length select {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
    }

    /* Calendar Styles */
    .calendar-toggle-section {
        margin: 20px 0;
        text-align: center;
    }

    .calendar-toggle-btn {
        background: linear-gradient(135deg, #75E6DA, #05445E);
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 25px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        box-shadow: 0 4px 15px rgba(117, 230, 218, 0.3);
    }

    .calendar-toggle-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(117, 230, 218, 0.4);
    }

    .calendar-toggle-btn:active {
        transform: translateY(0);
    }

    .calendar-toggle-btn i {
        font-size: 18px;
    }

    .calendar-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin: 20px 0;
        border: 1px solid #e5e7eb;
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f3f4f6;
    }

    .calendar-title {
        font-size: 18px;
        font-weight: 600;
        color: #05445E;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .calendar-nav {
        display: flex;
        gap: 10px;
    }

    .calendar-nav-btn {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        color: #64748b;
        padding: 8px 12px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 14px;
    }

    .calendar-nav-btn:hover {
        background: #e2e8f0;
        color: #05445E;
        border-color: #cbd5e1;
    }

    .calendar-nav-btn:active {
        transform: scale(0.95);
    }

    .calendar-nav-btn i {
        font-size: 12px;
    }

    .calendar-weekdays {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 2px;
        margin-bottom: 10px;
    }

    .calendar-weekday {
        text-align: center;
        padding: 12px 8px;
        font-weight: 600;
        color: #64748b;
        font-size: 14px;
        background: #f8fafc;
        border-radius: 8px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .calendar-days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 2px;
    }

    .calendar-day {
        aspect-ratio: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 14px;
        font-weight: 500;
        color: #374151;
        border: 1px solid transparent;
    }

    .calendar-day:hover {
        background: #f0f9ff;
        border-color: #0ea5e9;
        color: #0369a1;
    }

    .calendar-day.other-month {
        color: #9ca3af;
        background: #f9fafb;
    }

    .calendar-day.today {
        background: linear-gradient(135deg, #75E6DA, #05445E);
        color: white;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(117, 230, 218, 0.3);
    }

    .calendar-day.selected {
        background: #05445E;
        color: white;
        font-weight: 600;
        box-shadow: 0 2px 8px rgba(5, 68, 94, 0.3);
    }

    .calendar-day.has-event {
        background: #fef3c7;
        color: #92400e;
        border-color: #f59e0b;
        position: relative;
    }

    .calendar-day.has-event::after {
        content: '';
        position: absolute;
        bottom: 2px;
        left: 50%;
        transform: translateX(-50%);
        width: 4px;
        height: 4px;
        background: #f59e0b;
        border-radius: 50%;
    }

    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }

    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }

    .modal-container {
        background: white;
        border-radius: 16px;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        transform: translateY(20px);
        transition: all 0.3s ease;
        overflow: hidden;
    }

    .modal-overlay.active .modal-container {
        transform: translateY(0);
    }

    .modal-header {
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
        color: white;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
    }

    .modal-close {
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .modal-close:hover {
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 25px;
    }

    .detail-row {
        display: flex;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }

    .detail-row:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .detail-label {
        width: 120px;
        font-weight: 500;
        color: #666;
    }

    .detail-value {
        flex: 1;
        font-weight: 600;
        color: #05445E;
    }

    .detail-icon {
        width: 40px;
        height: 40px;
        background: #f0f8ff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        color: #05445E;
        font-size: 18px;
    }

    .detail-category {
        display: flex;
        align-items: center;
    }

    .detail-points {
        font-size: 24px;
        font-weight: 700;
        color: #05445E;
        text-align: center;
        margin: 20px 0;
        padding: 15px;
        background: #f8f9fc;
        border-radius: 10px;
    }

    .detail-points small {
        font-size: 14px;
        font-weight: 500;
        color: #666;
        display: block;
    }

    .modal-footer {
        padding: 15px 25px;
        background: #f8f9fc;
        display: flex;
        justify-content: flex-end;
        border-top: 1px solid #eee;
    }

    .modal-btn {
        padding: 10px 20px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .modal-btn-close {
        background: #e0e6ed;
        color: #666;
    }

    .modal-btn-close:hover {
        background: #d1d9e6;
    }

    .modal-btn-primary {
        background: linear-gradient(135deg, #75E6DA 0%, #05445E 100%);
        color: white;
        margin-left: 10px;
    }

    .modal-btn-primary:hover {
        opacity: 0.9;
        transform: translateY(-2px);
    }

    /* Tooltip Styles */
    .tooltip {
        position: relative;
        display: inline-block;
    }

    .tooltip .tooltiptext {
        visibility: hidden;
        width: 120px;
        background-color: #05445E;
        color: #fff;
        text-align: center;
        border-radius: 6px;
        padding: 5px;
        position: absolute;
        z-index: 1;
        bottom: 125%;
        left: 50%;
        transform: translateX(-50%);
        opacity: 0;
        transition: opacity 0.3s;
        font-size: 12px;
    }

    .tooltip .tooltiptext::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #05445E transparent transparent transparent;
    }

    .tooltip:hover .tooltiptext {
        visibility: visible;
        opacity: 1;
    }

    /* Footer */
    .footer {
        text-align: center;
        margin-top: 50px;
        font-size: 14px;
        color: #666;
    }

    .footer strong {
        font-weight: 700;
        color: #05445E;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .main-content-wrapper { 
            padding-left: 1rem; 
            padding-right: 1rem; 
        }
        .content-container { 
            padding: 1.5rem; 
        }
        .filter-group {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .filter-buttons {
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .bs-pay-section {
            flex-direction: column;
        }
        
        .bs-pay-card:first-child {
            flex: 1;
        }

        .bs-pay-card:nth-child(2) {
            flex: 1;
            height: 250px;
        }

        .date-filter {
            flex-direction: row;
            gap: 10px;
        }

        .date-input {
            width: 140px;
        }
    }

    @media (max-width: 768px) {
        .main-content-wrapper {
            padding-top: 20px;
        }
        
        .content-container {
            padding: 1rem;
        }

        .calendar-container {
            padding: 15px;
            margin: 15px 0;
        }

        .calendar-header {
            flex-direction: column;
            gap: 15px;
            align-items: stretch;
        }

        .calendar-nav {
            justify-content: center;
        }

        .calendar-weekday {
            padding: 8px 4px;
            font-size: 12px;
        }

        .calendar-day {
            font-size: 12px;
        }

        .kategori-grid {
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 15px;
        }

        .bs-pay-card {
            padding: 20px;
        }

        .bs-pay-logo {
            width: 60px;
            height: 60px;
            font-size: 20px;
        }

        .bs-pay-amount {
            font-size: 24px;
        }

        .table-section {
            padding: 20px;
        }

        .table-header {
            flex-direction: column;
            align-items: stretch;
            gap: 15px;
        }

        .filter-group {
            gap: 12px;
        }

        .date-filter {
            flex-direction: column;
            align-items: stretch;
        }

        .date-input {
            width: 100%;
        }

        .filter-buttons {
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .content-container {
            padding: 0.75rem;
        }

        .main-content-wrapper {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
        }

        .kategori-grid {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .filter-group {
            flex-direction: column;
            gap: 10px;
        }

        .date-filter {
            flex-direction: column;
            align-items: stretch;
        }

        .date-input {
            width: 100%;
        }

        .bs-pay-section {
            gap: 15px;
        }

        .bs-pay-card {
            padding: 15px;
        }

        .table-section {
            padding: 15px;
        }

        .section-title {
            font-size: 18px;
        }

        .bs-pay-amount {
            font-size: 20px;
        }

        .bs-pay-title {
            font-size: 16px;
        }

        .kategori-card {
            padding: 15px;
        }

        .kategori-icon {
            font-size: 32px;
        }
    }
</style>

<div class="flex min-h-screen bg-gray-50" x-data="{ sidebarOpen: false }">
    {{-- Sidebar Overlay --}}
    <div class="sidebar-overlay" :class="{ 'active': sidebarOpen }" @click="sidebarOpen = false"></div>

    {{-- Sidebar --}}
    <aside 
        x-data="{ open: false, active: 'penjemputan' }"
        x-ref="sidebar"
        @mouseenter="open = true; $root.sidebarOpen = true"
        @mouseleave="open = false; $root.sidebarOpen = false"
        class="fixed top-0 left-0 z-50 flex flex-col py-6 sidebar-hover overflow-hidden shadow-2xl group sidebar-gradient"
        :class="open ? 'w-64' : 'w-16'"
        style="transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1); margin-top: 48px; height: calc(100vh - 48px);"
    >
        <div class="relative flex flex-col h-full w-full px-4">
            {{-- Logo Section --}}
            <div class="flex items-center justify-center mb-8 mt-2 sidebar-logo">
                <img x-show="open" class="w-32 h-auto" src="{{ asset('asset/img/logo1.png') }}" alt="Logo Penuh">
                <img x-show="!open" class="w-6 h-6" src="{{ asset('asset/img/logo.png') }}" alt="Logo Ikon">
            </div>
            
            {{-- Navigation Menu --}}
            @include('partials.sidebar-nasabah', ['active' => 'penjemputan'])
        </div>
    </aside>

    {{-- Main Content Area --}}
    <div class="main-content-wrapper">
        {{-- Top Header Bar --}}
        <div class="fixed-header">
            <h1 class="text-white font-semibold text-lg">BijakSampah</h1>
            <div class="flex items-center gap-4">
                <button onclick="showDevelopmentModal('Notification')" class="relative hover:text-white/80 transition-colors">
                    <i class="far fa-bell text-white text-sm"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-medium">2</span>
                </button>
                <button onclick="showDevelopmentModal('Search')" class="focus:outline-none hover:text-white/80 transition-colors">
                    <i class="fas fa-search text-white text-sm"></i>
                </button>
                <div class="flex items-center gap-2">
                    <button onclick="showDevelopmentModal('Profile')" class="w-8 h-8 rounded-full overflow-hidden flex items-center justify-center border-2 border-gray-300 cursor-pointer hover:border-white/50 transition-colors">
                        <img src="https://ui-avatars.com/api/?name=Nasabah&background=75E6DA&color=05445E" alt="Profile" class="w-full h-full object-cover">
                    </button>
                    <button onclick="showDevelopmentModal('Profile Menu')" class="hover:text-white/80 transition-colors">
                        <i class="fas fa-chevron-down text-white text-xs"></i>
                    </button>
                </div>
            </div>
        </div>
        
        {{-- Content Container --}}
        <div class="content-container">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800"><i class="fas fa-history"></i> Riwayat Sampah</h1>
                    <p class="text-sm text-gray-500">Lihat dan kelola riwayat sampah Anda</p>
                </div>
                <button onclick="showPenjemputanModal()" class="btn-primary px-6 py-3 rounded-lg">
                    <i class="fas fa-plus mr-2"></i>Ajukan Penjemputan Sampah
                </button>
            </div>

        <div class="bs-pay-section">
      <div class="bs-pay-card">
                    <div class="bs-pay-logo">BS</div>
        <div class="bs-pay-info">
          <div class="bs-pay-title">BS, PAY!</div>
          <div class="bs-pay-amount">4.297 Koin</div>
          <div class="bs-pay-subtitle"><i class="fas fa-arrow-up"></i> Pemasukan bulan ini</div>
        </div>
      </div>
      
            <div class="bs-pay-card">
        <div class="pie-chart-container">
                        <img src="{{ asset('asset/img/pieChart.png') }}" alt="Pie Chart">
        </div>
      </div>
    </div>

        <div class="kategori-section">
      <h2 class="section-title"><i class="fas fa-list"></i> Kategori Sampah di Bijak Sampah</h2>
      
      <div class="kategori-grid">
        <div class="kategori-card">
          <i class="kategori-icon fas fa-bolt"></i>
          <div class="kategori-berat">1 kg</div>
          <div class="kategori-name">Besi</div>
          <div class="kategori-total">Total: 883 poin</div>
        </div>
        
        <div class="kategori-card">
          <i class="kategori-icon fas fa-bottle-water"></i>
          <div class="kategori-berat">1 kg</div>
          <div class="kategori-name">Plastik</div>
          <div class="kategori-total">Total: 116 poin</div>
        </div>
        
        <div class="kategori-card">
          <i class="kategori-icon fas fa-file-alt"></i>
          <div class="kategori-berat">1 kg</div>
          <div class="kategori-name">Kertas</div>
          <div class="kategori-total">Total: 393 poin</div>
        </div>
        
        <div class="kategori-card">
          <i class="kategori-icon fas fa-laptop"></i>
          <div class="kategori-berat">1 kg</div>
          <div class="kategori-name">Elektronik</div>
          <div class="kategori-total">Total: 564 poin</div>
        </div>
        
        <div class="kategori-card">
          <i class="kategori-icon fas fa-wine-glass"></i>
          <div class="kategori-berat">1 kg</div>
          <div class="kategori-name">Kaca</div>
          <div class="kategori-total">Total: 450 poin</div>
        </div>
        
        <div class="kategori-card">
          <i class="kategori-icon fas fa-box-open"></i>
          <div class="kategori-berat">0</div>
          <div class="kategori-name">Lainnya</div>
          <div class="kategori-total">Total: 0 poin</div>
        </div>
      </div>
    </div>

        <!-- Statistik Status Sampah -->
    <div class="status-stats-section" style="margin: 20px 0;">
      <h2 class="section-title"><i class="fas fa-chart-pie"></i> Statistik Status Sampah</h2>
      
      <!-- Filter Status Sampah -->
      <div class="status-filter-section" style="margin-bottom: 15px;">
        <div class="filter-buttons" style="display: flex; gap: 10px; flex-wrap: wrap;">
          <button class="filter-btn active" onclick="filterByStatus('all')" style="background: #3b82f6; color: white; padding: 8px 16px; border: none; border-radius: 20px; font-size: 14px; cursor: pointer; transition: all 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <i class="fas fa-list"></i> Semua Status
          </button>
          <button class="filter-btn" onclick="filterByStatus('Belum Selesai')" style="background: #6b7280; color: white; padding: 8px 16px; border: none; border-radius: 20px; font-size: 14px; cursor: pointer; transition: all 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <i class="fas fa-clock"></i> Belum Selesai
          </button>
          <button class="filter-btn" onclick="filterByStatus('Dalam Perjalanan')" style="background: #6b7280; color: white; padding: 8px 16px; border: none; border-radius: 20px; font-size: 14px; cursor: pointer; transition: all 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <i class="fas fa-truck"></i> Dalam Perjalanan
          </button>
          <button class="filter-btn" onclick="filterByStatus('Saat Penimbangan')" style="background: #6b7280; color: white; padding: 8px 16px; border: none; border-radius: 20px; font-size: 14px; cursor: pointer; transition: all 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <i class="fas fa-balance-scale"></i> Saat Penimbangan
          </button>
          <button class="filter-btn" onclick="filterByStatus('Selesai')" style="background: #6b7280; color: white; padding: 8px 16px; border: none; border-radius: 20px; font-size: 14px; cursor: pointer; transition: all 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <i class="fas fa-check-circle"></i> Selesai
          </button>
        </div>
      </div>
      
      <div class="status-stats-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 15px;">
        <div class="status-stat-card" style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 15px; border-radius: 8px;">
          <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-clock" style="color: #f59e0b; font-size: 24px;"></i>
            <div>
              <div style="font-size: 14px; color: #92400e; font-weight: 500;">Belum Selesai</div>
              <div style="font-size: 24px; font-weight: bold; color: #92400e;" id="countBelumSelesai">0</div>
            </div>
          </div>
        </div>
        
        <div class="status-stat-card" style="background: #dbeafe; border-left: 4px solid #3b82f6; padding: 15px; border-radius: 8px;">
          <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-truck" style="color: #3b82f6; font-size: 24px;"></i>
            <div>
              <div style="font-size: 14px; color: #1e40af; font-weight: 500;">Dalam Perjalanan</div>
              <div style="font-size: 24px; font-weight: bold; color: #1e40af;" id="countDalamPerjalanan">0</div>
            </div>
          </div>
        </div>
        
        <div class="status-stat-card" style="background: #f3e8ff; border-left: 4px solid #8b5cf6; padding: 15px; border-radius: 8px;">
          <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-balance-scale" style="color: #8b5cf6; font-size: 24px;"></i>
          <div>
              <div style="font-size: 14px; color: #7c3aed; font-weight: 500;">Saat Penimbangan</div>
              <div style="font-size: 24px; font-weight: bold; color: #7c3aed;" id="countSaatPenimbangan">0</div>
            </div>
          </div>
        </div>
        
        <div class="status-stat-card" style="background: #e3f9e5; border-left: 4px solid #10b981; padding: 15px; border-radius: 8px;">
          <div style="display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-check-circle" style="color: #10b981; font-size: 24px;"></i>
            <div>
              <div style="font-size: 14px; color: #1a7a2e; font-weight: 500;">Selesai</div>
              <div style="font-size: 24px; font-weight: bold; color: #1a7a2e;" id="countSelesai">0</div>
            </div>
          </div>
        </div>
      </div>
    </div>

        <div class="table-section">
      <div class="table-header">
        <h2 class="section-title"><i class="fas fa-table"></i> Pemasukan</h2>
        <div class="filter-group">
          <div class="date-filter">
            <div class="relative">
              <input type="text" class="date-input" id="startDate" placeholder="Mulai Tanggal" readonly>
              <button type="button" class="date-picker-btn" onclick="toggleDatePicker('startDate')">
                <i class="fas fa-calendar"></i>
              </button>
            </div>
            <span>s/d</span>
            <div class="relative">
              <input type="text" class="date-input" id="endDate" placeholder="Sampai Tanggal" readonly>
              <button type="button" class="date-picker-btn" onclick="toggleDatePicker('endDate')">
                <i class="fas fa-calendar"></i>
              </button>
            </div>
          </div>
          <div class="filter-buttons">
            <button class="filter-btn active" id="allFilter">
              <i class="fas fa-list"></i> Semua
            </button>
            <button class="filter-btn" id="monthFilter">
              <i class="fas fa-calendar-alt"></i> Bulan Ini
            </button>
            <div class="relative">
              <button class="filter-btn dropdown-toggle" id="monthDropdown" onclick="toggleMonthDropdown()">
                <i class="fas fa-filter"></i> Filter Bulan
                <i class="fas fa-chevron-down ml-2"></i>
              </button>
              <div class="month-dropdown" id="monthDropdownMenu">
                <div class="month-option" onclick="filterByMonth(1)">Januari</div>
                <div class="month-option" onclick="filterByMonth(2)">Februari</div>
                <div class="month-option" onclick="filterByMonth(3)">Maret</div>
                <div class="month-option" onclick="filterByMonth(4)">April</div>
                <div class="month-option" onclick="filterByMonth(5)">Mei</div>
                <div class="month-option" onclick="filterByMonth(6)">Juni</div>
                <div class="month-option" onclick="filterByMonth(7)">Juli</div>
                <div class="month-option" onclick="filterByMonth(8)">Agustus</div>
                <div class="month-option" onclick="filterByMonth(9)">September</div>
                <div class="month-option" onclick="filterByMonth(10)">Oktober</div>
                <div class="month-option" onclick="filterByMonth(11)">November</div>
                <div class="month-option" onclick="filterByMonth(12)">Desember</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <table id="riwayatTable" class="display" style="width:100%">
        <thead>
          <tr>
            <th>No.</th>
            <th>Tanggal</th>
            <th>Kategori</th>
            <th>Berat Sampah</th>
            <th>Koin</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
                        <!-- Data akan diisi oleh JavaScript -->
                  </tbody>
      </table>
    </div>

    <!-- Calendar Toggle Button -->
    <div class="calendar-toggle-section">
      <button class="calendar-toggle-btn" onclick="toggleCalendar()">
        <i class="fas fa-calendar-alt"></i>
        <span>Tampilkan Kalender</span>
      </button>
    </div>

    <!-- Calendar Section (Hidden by default) -->
    <div class="calendar-container" id="calendarContainer" style="display: none;">
      <div class="calendar-header">
        <div class="calendar-title">
          <i class="fas fa-calendar-alt"></i>
          <span id="currentMonth">Desember 2024</span>
        </div>
        <div class="calendar-nav">
          <button class="calendar-nav-btn" onclick="previousMonth()">
            <i class="fas fa-chevron-left"></i>
            Previous
          </button>
          <button class="calendar-nav-btn" onclick="nextMonth()">
            Next
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>
      </div>
      
      <div class="calendar-weekdays">
        <div class="calendar-weekday">Min</div>
        <div class="calendar-weekday">Sen</div>
        <div class="calendar-weekday">Sel</div>
        <div class="calendar-weekday">Rab</div>
        <div class="calendar-weekday">Kam</div>
        <div class="calendar-weekday">Jum</div>
        <div class="calendar-weekday">Sab</div>
      </div>
      
      <div class="calendar-days" id="calendarDays">
        <!-- Calendar days will be populated by JavaScript -->
      </div>
    </div>

            <!-- Modal Penjemputan Sampah -->
            <div class="modal-overlay" id="penjemputanModal">
                <div class="modal-container">
                    <div class="modal-header">
                        <h3>Ajukan Penjemputan Sampah</h3>
                        <button class="modal-close" onclick="closePenjemputanModal()">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form id="penjemputanForm">
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori Sampah</label>
                                <select id="categorySelect" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                                    <option value="">Pilih Kategori</option>
                                    <option value="plastik">Plastik</option>
                                    <option value="besi">Besi</option>
                                    <option value="kertas">Kertas</option>
                                    <option value="elektronik">Elektronik</option>
                                    <option value="kaca">Kaca</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Berat Sampah (kg)</label>
                                <input type="number" id="weightInput" step="0.1" min="0.1" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan berat sampah" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Lokasi Penjemputan</label>
                                <input type="text" id="locationInput" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan alamat lengkap" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Penjemputan</label>
                                <input type="date" id="dateInput" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Catatan (Opsional)</label>
                                <textarea id="notesInput" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" rows="3" placeholder="Tambahkan catatan jika diperlukan"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="modal-btn modal-btn-close" onclick="closePenjemputanModal()">Batal</button>
                        <button class="modal-btn modal-btn-primary" onclick="submitPenjemputan()">Ajukan Penjemputan</button>
                    </div>
                </div>
            </div>

            <!-- Modal Detail Transaksi -->
  <div class="modal-overlay" id="detailModal">
    <div class="modal-container">
      <div class="modal-header">
        <h3>Detail Transaksi</h3>
        <button class="modal-close" id="modalClose">&times;</button>
      </div>
      <div class="modal-body" id="modalBody">
        <!-- Content will be inserted here dynamically -->
      </div>
      <div class="modal-footer">
        <button class="modal-btn modal-btn-close" id="modalBtnClose">Tutup</button>
                    </div>
                </div>
            </div>

            <div class="footer">
                Created by <strong>TEK(G)</strong> | All Right Reserved!
            </div>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
  <script>
    // Show Development Modal
    function showDevelopmentModal(featureName) {
        const modal = document.createElement('div');
        modal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center';
        modal.innerHTML = `
            <div class="bg-white rounded-2xl p-8 max-w-md mx-4 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-tools text-blue-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">${featureName} - Fitur Dalam Pengembangan</h3>
                <p class="text-gray-600 mb-4">Fitur ini sedang dalam tahap pengembangan. Tim kami sedang bekerja keras untuk menghadirkan pengalaman terbaik untuk Anda.</p>
                <div class="bg-blue-50 rounded-lg p-4 mb-6">
                    <p class="text-sm text-blue-600">
                        <i class="fas fa-clock"></i> Estimasi rilis: 2-3 minggu ke depan
                    </p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition-colors">
                    Mengerti
                </button>
            </div>
        `;
        document.body.appendChild(modal);
    }

    // Modal Penjemputan functions
    function showPenjemputanModal() {
        document.getElementById('penjemputanModal').classList.add('active');
    }

    function closePenjemputanModal() {
        document.getElementById('penjemputanModal').classList.remove('active');
        // Reset form
        document.getElementById('penjemputanForm').reset();
    }

    function submitPenjemputan() {
        // Validasi form
        const form = document.getElementById('penjemputanForm');
        const formData = new FormData(form);
        
        // Simulasi submit dengan data yang diinput user
        const category = document.getElementById('categorySelect').value;
        const weight = document.getElementById('weightInput').value;
        const location = document.getElementById('locationInput').value;
        const date = document.getElementById('dateInput').value;
        const notes = document.getElementById('notesInput').value;
        
        if (!category || !weight || !location || !date) {
            alert('Mohon lengkapi semua field yang wajib diisi!');
            return;
        }
        
        // Simulasi submit berhasil
        alert('Penjemputan sampah berhasil diajukan!');
        closePenjemputanModal();
        
        // Tambahkan data baru ke tabel
        addNewPenjemputanData(category, weight, location, date, notes);
    }

    // Fungsi untuk menambah data penjemputan baru
    function addNewPenjemputanData(category, weight, location, date, notes) {
        const today = new Date();
        const formattedDate = today.toLocaleDateString('id-ID');
        const dayName = today.toLocaleDateString('id-ID', { weekday: 'long' });
        
        // Hitung poin berdasarkan kategori
        const pointsPerKg = getPointsPerKg(category);
        const totalPoints = Math.floor(weight * pointsPerKg);
        
        // Status default untuk input manual adalah "Belum Selesai"
        const statusBadge = getStatusBadge('Belum Selesai');
        
        const newRow = `
            <tr class="new-row" style="background-color: #f0f9ff;">
                <td>1</td>
                <td>${dayName}, ${formattedDate}</td>
                <td>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i class="${getCategoryIcon(category)}" style="color: #05445E;"></i>
                        ${category}
                    </div>
                </td>
                <td>${parseFloat(weight).toFixed(1)} kg</td>
                <td><strong>${totalPoints}</strong></td>
                <td>${statusBadge}</td>
                <td>
                    <div class="tooltip">
                        <button class="action-btn" title="Detail" onclick="showDetailModal(this)">
                            <i class="fas fa-eye"></i>
                        </button>
                        <span class="tooltiptext">Lihat Detail</span>
                    </div>
                </td>
            </tr>
        `;
        
        // Tambahkan ke tabel dan refresh DataTable
        const table = $('#riwayatTable').DataTable();
        table.row.add($(newRow)).draw();
        
        // Update nomor urut
        updateRowNumbers();
        
        // Update statistik status sampah
        updateStatusStats();
        
        // Tambahkan animasi highlight
        setTimeout(() => {
            $('.new-row').removeClass('new-row').css('background-color', 'white');
        }, 3000);
    }

    // Fungsi untuk mendapatkan style status badge
    function getStatusBadge(status) {
      const statusStyles = {
        'Belum Selesai': { bgColor: '#fef3c7', textColor: '#92400e', icon: 'fas fa-clock' },
        'Dalam Perjalanan': { bgColor: '#dbeafe', textColor: '#1e40af', icon: 'fas fa-truck' },
        'Saat Penimbangan': { bgColor: '#f3e8ff', textColor: '#7c3aed', icon: 'fas fa-balance-scale' },
        'Selesai': { bgColor: '#e3f9e5', textColor: '#1a7a2e', icon: 'fas fa-check-circle' }
      };
      
      const style = statusStyles[status] || statusStyles['Belum Selesai'];
      return `<span style="display:inline-block;padding:4px 10px;background:${style.bgColor};color:${style.textColor};border-radius:20px;font-size:12px;font-weight:500"><i class="${style.icon}"></i> ${status}</span>`;
    }

    // Fungsi untuk mendapatkan poin per kg berdasarkan kategori
    function getPointsPerKg(category) {
        const pointsMap = {
            'plastik': 116,
            'besi': 883,
            'kertas': 393,
            'elektronik': 564,
            'kaca': 450,
            'lainnya': 100
        };
        return pointsMap[category] || 100;
    }

    // Fungsi untuk mendapatkan ikon kategori
    function getCategoryIcon(category) {
        const iconMap = {
            'plastik': 'fas fa-bottle-water',
            'besi': 'fas fa-bolt',
            'kertas': 'fas fa-file-alt',
            'elektronik': 'fas fa-laptop',
            'kaca': 'fas fa-wine-glass',
            'lainnya': 'fas fa-box-open'
        };
        return iconMap[category] || 'fas fa-trash-alt';
    }

    // Fungsi untuk update nomor urut
    function updateRowNumbers() {
        const table = $('#riwayatTable').DataTable();
        table.rows().every(function() {
            const data = this.data();
            data[0] = this.index() + 1;
            this.data(data);
        });
    }

    function addDummyData() {
        const newData = {
            date: new Date().toLocaleDateString('id-ID'),
            day: new Date().toLocaleDateString('id-ID', { weekday: 'long' }),
            category: 'Plastik',
            weight: 2.5,
            pointsPerKg: 116
        };
        
        const points = (newData.weight * newData.pointsPerKg).toFixed(0);
        const newRow = `
            <tr>
                <td>1</td>
                <td>${newData.day}, ${newData.date}</td>
                <td>
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-bottle-water" style="color: #05445E;"></i>
                        ${newData.category}
    </div>
                </td>
                <td>${newData.weight.toFixed(1)} kg</td>
                <td><strong>${points}</strong></td>
                <td>
                    <div class="tooltip">
                        <button class="action-btn" title="Detail"><i class="fas fa-eye"></i></button>
                        <span class="tooltiptext">Lihat Detail</span>
    </div>
                </td>
            </tr>
        `;
        
        $('#riwayatTable tbody').prepend(newRow);
    }

    $(document).ready(function () {
      // Data dummy yang lebih realistis dengan variasi tanggal dan berat pecahan
      const dummyData = [
        { date: '28/07/2025', day: 'Senin', category: 'Plastik', weight: 1.2, pointsPerKg: 116, status: 'Belum Selesai' },
        { date: '27/07/2025', day: 'Minggu', category: 'Besi', weight: 1.5, pointsPerKg: 883, status: 'Dalam Perjalanan' },
        { date: '25/07/2025', day: 'Jumat', category: 'Kertas', weight: 0.8, pointsPerKg: 393, status: 'Saat Penimbangan' },
        { date: '22/07/2025', day: 'Selasa', category: 'Plastik', weight: 2.3, pointsPerKg: 116, status: 'Selesai' },
        { date: '20/07/2025', day: 'Minggu', category: 'Kaca', weight: 1.7, pointsPerKg: 450, status: 'Belum Selesai' },
        { date: '18/07/2025', day: 'Jumat', category: 'Elektronik', weight: 0.5, pointsPerKg: 564, status: 'Dalam Perjalanan' },
        { date: '15/07/2025', day: 'Selasa', category: 'Kertas', weight: 1.0, pointsPerKg: 393, status: 'Saat Penimbangan' },
        { date: '12/07/2025', day: 'Sabtu', category: 'Besi', weight: 2.2, pointsPerKg: 883, status: 'Selesai' },
        { date: '10/07/2025', day: 'Kamis', category: 'Plastik', weight: 1.8, pointsPerKg: 116, status: 'Belum Selesai' },
        { date: '05/07/2025', day: 'Sabtu', category: 'Kaca', weight: 0.9, pointsPerKg: 450, status: 'Dalam Perjalanan' },
        { date: '30/06/2025', day: 'Senin', category: 'Elektronik', weight: 1.3, pointsPerKg: 564, status: 'Saat Penimbangan' },
        { date: '28/06/2025', day: 'Sabtu', category: 'Kertas', weight: 2.5, pointsPerKg: 393, status: 'Selesai' },
        { date: '25/06/2025', day: 'Rabu', category: 'Besi', weight: 1.1, pointsPerKg: 883, status: 'Belum Selesai' },
        { date: '20/06/2025', day: 'Jumat', category: 'Plastik', weight: 0.7, pointsPerKg: 116, status: 'Dalam Perjalanan' },
        { date: '18/06/2025', day: 'Rabu', category: 'Kaca', weight: 1.4, pointsPerKg: 450, status: 'Saat Penimbangan' }
      ];



      // Fungsi untuk mengisi tabel dengan data
      function populateTable() {
        const tableBody = $('#riwayatTable tbody');
        tableBody.empty();
        dummyData.forEach((item, index) => {
          const points = (item.weight * item.pointsPerKg).toFixed(0);
          const row = `
            <tr>
              <td>${index + 1}</td>
              <td>${item.day}, ${item.date}</td>
              <td>
                <div style="display: flex; align-items: center; gap: 8px;">
                  ${getCategoryIcon(item.category)}
                  ${item.category}
                </div>
              </td>
              <td>${item.weight.toFixed(1)} kg</td>
              <td><strong>${points}</strong></td>
              <td>${getStatusBadge(item.status)}</td>
              <td>
                <div class="tooltip">
                  <button class="action-btn" title="Detail" onclick="showDetailModal(this)"><i class="fas fa-eye"></i></button>
                  <span class="tooltiptext">Lihat Detail</span>
                </div>
              </td>
            </tr>
          `;
          tableBody.append(row);
        });
        
        // Update statistik status sampah setelah tabel diisi
        updateStatusStats();
      }

      // Fungsi untuk mengupdate statistik status sampah
      function updateStatusStats() {
        const countBelumSelesai = dummyData.filter(item => item.status === 'Belum Selesai').length;
        const countDalamPerjalanan = dummyData.filter(item => item.status === 'Dalam Perjalanan').length;
        const countSaatPenimbangan = dummyData.filter(item => item.status === 'Saat Penimbangan').length;
        const countSelesai = dummyData.filter(item => item.status === 'Selesai').length;
        
        // Update elemen HTML
        document.getElementById('countBelumSelesai').textContent = countBelumSelesai;
        document.getElementById('countDalamPerjalanan').textContent = countDalamPerjalanan;
        document.getElementById('countSaatPenimbangan').textContent = countSaatPenimbangan;
        document.getElementById('countSelesai').textContent = countSelesai;
      }

      // Fungsi untuk filter berdasarkan status
      function filterByStatus(status) {
        const table = $('#riwayatTable').DataTable();
        
        // Update active state pada tombol filter
        document.querySelectorAll('.status-filter-section .filter-btn').forEach(btn => {
          btn.classList.remove('active');
          btn.style.background = '#6b7280';
          btn.style.transform = 'scale(1)';
        });
        
        // Aktifkan tombol yang dipilih
        event.target.classList.add('active');
        event.target.style.transform = 'scale(1.05)';
        if (status === 'all') {
          event.target.style.background = '#3b82f6';
        } else if (status === 'Belum Selesai') {
          event.target.style.background = '#f59e0b';
        } else if (status === 'Dalam Perjalanan') {
          event.target.style.background = '#3b82f6';
        } else if (status === 'Saat Penimbangan') {
          event.target.style.background = '#8b5cf6';
        } else if (status === 'Selesai') {
          event.target.style.background = '#10b981';
        }
        
        if (status === 'all') {
          table.search('').draw();
        } else {
          // Filter berdasarkan status yang dipilih
          $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            const rowStatus = data[5]; // Kolom status (index 5)
            return rowStatus.includes(status);
          });
          table.draw();
          
          // Hapus filter setelah draw
          $.fn.dataTable.ext.search.pop();
        }
        
        // Update statistik berdasarkan filter
        updateFilteredStats(status);
      }

      // Fungsi untuk mengupdate statistik berdasarkan filter
      function updateFilteredStats(filterStatus) {
        let filteredData = dummyData;
        
        if (filterStatus !== 'all') {
          filteredData = dummyData.filter(item => item.status === filterStatus);
        }
        
        const countBelumSelesai = filteredData.filter(item => item.status === 'Belum Selesai').length;
        const countDalamPerjalanan = filteredData.filter(item => item.status === 'Dalam Perjalanan').length;
        const countSaatPenimbangan = filteredData.filter(item => item.status === 'Saat Penimbangan').length;
        const countSelesai = filteredData.filter(item => item.status === 'Selesai').length;
        
        // Update elemen HTML dengan data yang sudah difilter
        document.getElementById('countBelumSelesai').textContent = countBelumSelesai;
        document.getElementById('countDalamPerjalanan').textContent = countDalamPerjalanan;
        document.getElementById('countSaatPenimbangan').textContent = countSaatPenimbangan;
        document.getElementById('countSelesai').textContent = countSelesai;
      }

      // Fungsi untuk mendapatkan ikon berdasarkan kategori
      function getCategoryIcon(category) {
        const icons = {
          'Plastik': 'fas fa-bottle-water',
          'Besi': 'fas fa-bolt',
          'Kertas': 'fas fa-file-alt',
          'Elektronik': 'fas fa-laptop',
          'Kaca': 'fas fa-wine-glass',
          'Lainnya': 'fas fa-box-open'
        };
        return `<i class="${icons[category] || 'fas fa-trash-alt'}" style="color: #05445E;"></i>`;
      }

      populateTable();

      // Update statistik status sampah saat halaman dimuat
      updateStatusStats();

      // Inisialisasi DataTables
      const table = $('#riwayatTable').DataTable({
        pageLength: 10,
        lengthMenu: [10, 20, 50],
        searching: true,
        info: true,
        language: {
          search: "Cari:",
          lengthMenu: "Tampilkan _MENU_ entri",
          info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
          paginate: {
            next: "Berikutnya",
            previous: "Sebelumnya"
          }
        }
      });

      // Inisialisasi datepicker
      flatpickr("#startDate, #endDate", {
        dateFormat: "d/m/Y",
        locale: "id",
        allowInput: true
      });

      // Filter tanggal
      $('#startDate, #endDate').on('change', function() {
        table.draw();
        // Update statistik setelah filter tanggal
        setTimeout(() => {
          updateStatusStats();
        }, 100);
      });

      // Filter bulan ini
      $('#monthFilter').click(function() {
        const now = new Date();
        const firstDay = new Date(now.getFullYear(), now.getMonth(), 1);
        const lastDay = new Date(now.getFullYear(), now.getMonth() + 1, 0);
        
        $('#startDate').val(flatpickr.formatDate(firstDay, "d/m/Y"));
        $('#endDate').val(flatpickr.formatDate(lastDay, "d/m/Y"));
        table.draw();
        
        // Update button active state
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
      });

      // Filter semua
      $('#allFilter').click(function() {
        $('#startDate').val('');
        $('#endDate').val('');
        table.draw();
        
        // Update button active state
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
      });

      // Custom filter untuk tanggal
      $.fn.dataTable.ext.search.push(
        function(settings, data, dataIndex) {
          const startDateStr = $('#startDate').val();
          const endDateStr = $('#endDate').val();
          
          if (!startDateStr && !endDateStr) {
            return true;
          }
          
          const dateStr = data[1].split(',')[1].trim(); // Ambil bagian tanggal dari "Hari, DD/MM/YYYY"
          const dateParts = dateStr.split('/');
          const rowDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);
          
          let start = null;
          if (startDateStr) {
            const startParts = startDateStr.split('/');
            start = new Date(startParts[2], startParts[1] - 1, startParts[0]);
          }
          
          let end = null;
          if (endDateStr) {
            const endParts = endDateStr.split('/');
            end = new Date(endParts[2], endParts[1] - 1, endParts[0]);
            end.setHours(23, 59, 59, 999);
          }
          
          return (
            (!start || rowDate >= start) &&
            (!end || rowDate <= end)
          );
        }
      );

        // Aksi tombol di tabel dengan popup detail
      $(document).on('click', '.action-btn', function() {
        const row = $(this).closest('tr');
          const date = row.find('td:nth-child(2)').text();
          const category = row.find('td:nth-child(3)').text().trim();
          const weight = row.find('td:nth-child(4)').text();
          const points = row.find('td:nth-child(5)').text();
          
            // Extract category name (remove icon)
            const categoryName = category.replace(/<[^>]*>/g, '').trim();
            
            // Get category icon
            const categoryIcon = $(row.find('td:nth-child(3) i')).attr('class');
            
            // Calculate points per kg
            const weightValue = parseFloat(weight);
            const pointsValue = parseInt(points.replace(/\./g, ''));
            const pointsPerKg = (pointsValue / weightValue).toFixed(0);
            
            // Generate random status untuk demo (dalam implementasi nyata ini akan dari database)
            const statusOptions = [
              { text: 'Belum Selesai', class: 'pending', icon: 'fas fa-clock', bgColor: '#fef3c7', textColor: '#92400e' },
              { text: 'Dalam Perjalanan', class: 'in-transit', icon: 'fas fa-truck', bgColor: '#dbeafe', textColor: '#1e40af' },
              { text: 'Saat Penimbangan', class: 'weighing', icon: 'fas fa-balance-scale', bgColor: '#f3e8ff', textColor: '#7c3aed' },
              { text: 'Selesai', class: 'completed', icon: 'fas fa-check-circle', bgColor: '#e3f9e5', textColor: '#1a7a2e' }
            ];
            
            // Random status selection (dalam implementasi nyata ini akan berdasarkan data aktual)
            const randomStatus = statusOptions[Math.floor(Math.random() * statusOptions.length)];
            
            // Format modal content
            const modalContent = `
                <div class="detail-row">
                    <div class="detail-icon"><i class="${categoryIcon}"></i></div>
                    <div style="flex:1">
                        <div class="detail-category">
                            <div style="font-weight:600;color:#05445E;font-size:18px">${categoryName}</div>
                        </div>
                        <div style="font-size:14px;color:#666">${date}</div>
                    </div>
                </div>
                
                <div class="detail-points">
                    ${points} Koin
                    <small>${weight} × ${pointsPerKg} koin/kg</small>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Status</div>
                    <div class="detail-value"><span style="display:inline-block;padding:4px 10px;background:${randomStatus.bgColor};color:${randomStatus.textColor};border-radius:20px;font-size:13px;font-weight:500"><i class="${randomStatus.icon}"></i> ${randomStatus.text}</span></div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Waktu Transaksi</div>
                    <div class="detail-value">${getRandomTime()}</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Lokasi</div>
                    <div class="detail-value">Bank Sampah ${getRandomLocation()}</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">ID Transaksi</div>
                    <div class="detail-value">BS-${Math.random().toString(36).substr(2, 8).toUpperCase()}</div>
                </div>
            `;
            
            // Insert content and show modal
            $('#modalBody').html(modalContent);
            $('#detailModal').addClass('active');
        });

        // Fungsi untuk menampilkan modal detail dari JavaScript
        function showDetailModal(button) {
            const row = $(button).closest('tr');
            const date = row.find('td:nth-child(2)').text();
            const category = row.find('td:nth-child(3)').text().trim();
            const weight = row.find('td:nth-child(4)').text();
            const points = row.find('td:nth-child(5)').text();
            
            // Extract category name (remove icon)
            const categoryName = category.replace(/<[^>]*>/g, '').trim();
            
            // Get category icon
            const categoryIcon = $(row.find('td:nth-child(3) i')).attr('class');
            
            // Calculate points per kg
            const weightValue = parseFloat(weight);
            const pointsValue = parseInt(points.replace(/\./g, ''));
            const pointsPerKg = (pointsValue / weightValue).toFixed(0);
            
            // Generate random status untuk demo (dalam implementasi nyata ini akan dari database)
            const statusOptions = [
              { text: 'Belum Selesai', class: 'pending', icon: 'fas fa-clock', bgColor: '#fef3c7', textColor: '#92400e' },
              { text: 'Dalam Perjalanan', class: 'in-transit', icon: 'fas fa-truck', bgColor: '#dbeafe', textColor: '#1e40af' },
              { text: 'Saat Penimbangan', class: 'weighing', icon: 'fas fa-balance-scale', bgColor: '#f3e8ff', textColor: '#7c3aed' },
              { text: 'Selesai', class: 'completed', icon: 'fas fa-check-circle', bgColor: '#e3f9e5', textColor: '#1a7a2e' }
            ];
            
            // Random status selection (dalam implementasi nyata ini akan berdasarkan data aktual)
            const randomStatus = statusOptions[Math.floor(Math.random() * statusOptions.length)];
            
            // Format modal content
            const modalContent = `
                <div class="detail-row">
                    <div class="detail-icon"><i class="${categoryIcon}"></i></div>
                    <div style="flex:1">
                        <div class="detail-category">
                            <div style="font-weight:600;color:#05445E;font-size:18px">${categoryName}</div>
                        </div>
                        <div style="font-size:14px;color:#666">${date}</div>
                    </div>
                </div>
                
                <div class="detail-points">
                    ${points} Koin
                    <small>${weight} × ${pointsPerKg} koin/kg</small>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Status</div>
                    <div class="detail-value"><span style="display:inline-block;padding:4px 10px;background:${randomStatus.bgColor};color:${randomStatus.textColor};border-radius:20px;font-size:13px;font-weight:500"><i class="${randomStatus.icon}"></i> ${randomStatus.text}</span></div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Waktu Transaksi</div>
                    <div class="detail-value">${getRandomTime()}</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">Lokasi</div>
                    <div class="detail-value">Bank Sampah ${getRandomLocation()}</div>
                </div>
                
                <div class="detail-row">
                    <div class="detail-label">ID Transaksi</div>
                    <div class="detail-value">BS-${Math.random().toString(36).substr(2, 8).toUpperCase()}</div>
                </div>
            `;
            
            // Insert content and show modal
            $('#modalBody').html(modalContent);
            $('#detailModal').addClass('active');
        }

        // Function to generate random time
        function getRandomTime() {
            const hours = Math.floor(Math.random() * 12) + 8; // Between 8-19
            const minutes = Math.floor(Math.random() * 60);
            return `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')} WIB`;
        }

        // Function to generate random location
        function getRandomLocation() {
            const locations = [
                "Sudirman", 
                "Thamrin", 
                "Kebayoran", 
                "Pondok Indah", 
                "Grogol", 
                "Cipete", 
                "Kemang"
            ];
            return locations[Math.floor(Math.random() * locations.length)];
        }

        // Close modal
        $('#modalClose, #modalBtnClose').click(function() {
            $('#detailModal').removeClass('active');
        });

        // Close modal when clicking outside
        $('#detailModal').click(function(e) {
            if ($(e.target).hasClass('modal-overlay')) {
                $(this).removeClass('active');
            }
        });

        // Update table when sidebar state changes
        setTimeout(() => {
            table.columns.adjust().draw();
        }, 300);

        // Calendar functionality
        let currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();
        let calendarVisible = false;

        function toggleCalendar() {
            const calendarContainer = document.getElementById('calendarContainer');
            const toggleBtn = document.querySelector('.calendar-toggle-btn span');
            const toggleIcon = document.querySelector('.calendar-toggle-btn i');
            
            if (calendarVisible) {
                // Hide calendar
                calendarContainer.style.display = 'none';
                toggleBtn.textContent = 'Tampilkan Kalender';
                toggleIcon.className = 'fas fa-calendar-alt';
                calendarVisible = false;
            } else {
                // Show calendar
                calendarContainer.style.display = 'block';
                toggleBtn.textContent = 'Sembunyikan Kalender';
                toggleIcon.className = 'fas fa-calendar-times';
                calendarVisible = true;
                
                // Render calendar if not already rendered
                if (document.getElementById('calendarDays').children.length === 0) {
                    renderCalendar();
                }
            }
        }

        function renderCalendar() {
            const monthNames = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            document.getElementById('currentMonth').textContent = `${monthNames[currentMonth]} ${currentYear}`;

            const firstDay = new Date(currentYear, currentMonth, 1);
            const lastDay = new Date(currentYear, currentMonth + 1, 0);
            const startingDay = firstDay.getDay();
            const monthLength = lastDay.getDate();

            let calendarHTML = '';

            // Previous month days
            const prevMonthLastDay = new Date(currentYear, currentMonth, 0).getDate();
            for (let i = startingDay - 1; i >= 0; i--) {
                const day = prevMonthLastDay - i;
                calendarHTML += `<div class="calendar-day other-month">${day}</div>`;
            }

            // Current month days
            for (let day = 1; day <= monthLength; day++) {
                const isToday = day === currentDate.getDate() && currentMonth === currentDate.getMonth() && currentYear === currentDate.getFullYear();
                const hasEvent = Math.random() > 0.7; // Random events for demo
                
                let dayClass = 'calendar-day';
                if (isToday) dayClass += ' today';
                if (hasEvent) dayClass += ' has-event';
                
                calendarHTML += `<div class="${dayClass}" onclick="selectDate(${day})">${day}</div>`;
            }

            // Next month days
            const remainingDays = 42 - (startingDay + monthLength); // 6 rows * 7 days
            for (let day = 1; day <= remainingDays; day++) {
                calendarHTML += `<div class="calendar-day other-month">${day}</div>`;
            }

            document.getElementById('calendarDays').innerHTML = calendarHTML;
        }

        function previousMonth() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar();
        }

        function nextMonth() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar();
        }

        function selectDate(day) {
            // Remove previous selection
            document.querySelectorAll('.calendar-day.selected').forEach(el => {
                el.classList.remove('selected');
            });
            
            // Add selection to clicked day
            event.target.classList.add('selected');
            
            // You can add logic here to show events for the selected date
            console.log(`Selected date: ${day}/${currentMonth + 1}/${currentYear}`);
        }

        // Initialize calendar
        renderCalendar();

        // Fungsi untuk dropdown bulan
        function toggleMonthDropdown() {
            const dropdown = document.getElementById('monthDropdownMenu');
            dropdown.classList.toggle('show');
        }

        // Fungsi untuk filter berdasarkan bulan
        function filterByMonth(month) {
            const monthNames = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];
            
            const currentYear = new Date().getFullYear();
            const firstDay = new Date(currentYear, month - 1, 1);
            const lastDay = new Date(currentYear, month, 0);
            
            $('#startDate').val(flatpickr.formatDate(firstDay, "d/m/Y"));
            $('#endDate').val(flatpickr.formatDate(lastDay, "d/m/Y"));
            
            // Update button text
            document.getElementById('monthDropdown').innerHTML = `
                <i class="fas fa-filter"></i> ${monthNames[month - 1]}
                <i class="fas fa-chevron-down ml-2"></i>
            `;
            
            // Close dropdown
            document.getElementById('monthDropdownMenu').classList.remove('show');
            
            // Update active state
            $('.filter-btn').removeClass('active');
            $('#monthDropdown').addClass('active');
            
            // Apply filter
            table.draw();
            
            // Update statistik setelah filter bulan
            setTimeout(() => {
              updateStatusStats();
            }, 100);
        }

        // Fungsi untuk toggle date picker
        function toggleDatePicker(inputId) {
            const input = document.getElementById(inputId);
            if (input._flatpickr) {
                input._flatpickr.open();
            }
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdown = document.getElementById('monthDropdownMenu');
            const dropdownBtn = document.getElementById('monthDropdown');
            
            if (!dropdown.contains(event.target) && !dropdownBtn.contains(event.target)) {
                dropdown.classList.remove('show');
            }
        });

        // Perbaikan pagination DataTables
        table.on('page.dt', function() {
            // Update nomor urut setelah pindah halaman
            setTimeout(() => {
                updateRowNumbers();
            }, 100);
        });

        // Perbaikan tombol Previous dan Next
        table.on('draw.dt', function() {
            // Pastikan tombol pagination berfungsi dengan benar
            const info = table.page.info();
            if (info.pages <= 1) {
                $('.dataTables_paginate').hide();
            } else {
                $('.dataTables_paginate').show();
            }
        });
    });
  </script>

  <!-- E-Wallet Modal -->
  <div id="ewalletModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden">
      <div class="flex items-center justify-center min-h-screen p-4">
          <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-4">
              <!-- Header -->
              <div class="flex items-center justify-between p-6 border-b border-gray-200">
                  <h3 class="text-xl font-bold text-gray-800">E-Wallet</h3>
                  <button onclick="closeEwalletModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                      <i class="fas fa-times text-xl"></i>
                  </button>
              </div>

              <!-- Step 1: Input Nominal -->
              <div id="step1" class="p-6">
                  <div class="text-center mb-6">
                      <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                          <i class="fas fa-wallet text-white text-2xl"></i>
                      </div>
                      <h4 class="text-lg font-semibold text-gray-800 mb-2">Input Nominal</h4>
                      <p class="text-gray-600 text-sm">Masukkan nominal yang ingin ditukar</p>
                  </div>

                  <div class="space-y-4">
                      <div>
                          <label class="block text-sm font-medium text-gray-700 mb-2">Nominal (Rp)</label>
                          <input type="number" id="ewalletAmount" placeholder="0" 
                                 class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:border-blue-500 focus:outline-none transition-colors text-center text-lg font-semibold">
                      </div>
                      
                      <div class="bg-gray-50 rounded-xl p-4">
                          <div class="flex justify-between items-center text-sm">
                              <span class="text-gray-600">Poin yang akan ditukar:</span>
                              <span id="pointsToExchange" class="font-semibold text-blue-600">0 poin</span>
                          </div>
                          <div class="flex justify-between items-center text-sm mt-2">
                              <span class="text-gray-600">Sisa poin:</span>
                              <span id="remainingPoints" class="font-semibold text-green-600">0 poin</span>
                          </div>
                      </div>

                      <button onclick="nextToStep2()" id="nextStep1Btn" 
                              class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-blue-600 hover:to-purple-700 transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                          Lanjutkan
                      </button>
                  </div>
              </div>

              <!-- Step 2: Konfirmasi -->
              <div id="step2" class="p-6 hidden">
                  <div class="text-center mb-6">
                      <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                          <i class="fas fa-check-circle text-white text-2xl"></i>
                      </div>
                      <h4 class="text-lg font-semibold text-gray-800 mb-2">Konfirmasi Penukaran</h4>
                      <p class="text-gray-600 text-sm">Periksa detail penukaran Anda</p>
                  </div>

                  <div class="bg-gray-50 rounded-xl p-4 mb-6">
                      <div class="space-y-3">
                          <div class="flex justify-between items-center">
                              <span class="text-gray-600">Nominal E-Wallet:</span>
                              <span id="confirmAmount" class="font-semibold text-gray-800">Rp 0</span>
                          </div>
                          <div class="flex justify-between items-center">
                              <span class="text-gray-600">Poin yang ditukar:</span>
                              <span id="confirmPoints" class="font-semibold text-blue-600">0 poin</span>
                          </div>
                          <div class="flex justify-between items-center">
                              <span class="text-gray-600">Biaya admin:</span>
                              <span class="font-semibold text-gray-800">Rp 0</span>
                          </div>
                          <hr class="border-gray-300">
                          <div class="flex justify-between items-center">
                              <span class="text-gray-800 font-semibold">Total:</span>
                              <span id="confirmTotal" class="font-bold text-lg text-blue-600">Rp 0</span>
                          </div>
                      </div>
                  </div>

                  <div class="flex space-x-3">
                      <button onclick="backToStep1()" 
                              class="flex-1 bg-gray-200 text-gray-700 py-3 rounded-xl font-semibold hover:bg-gray-300 transition-colors">
                          Kembali
                      </button>
                      <button onclick="confirmExchange()" 
                              class="flex-1 bg-gradient-to-r from-green-500 to-blue-600 text-white py-3 rounded-xl font-semibold hover:from-green-600 hover:to-blue-700 transition-all duration-200">
                          Konfirmasi
                      </button>
                  </div>
              </div>

              <!-- Step 3: Riwayat -->
              <div id="step3" class="p-6 hidden">
                  <div class="text-center mb-6">
                      <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-600 rounded-full flex items-center justify-center mx-auto mb-4">
                          <i class="fas fa-history text-white text-2xl"></i>
                      </div>
                      <h4 class="text-lg font-semibold text-gray-800 mb-2">Riwayat Transaksi</h4>
                      <p class="text-gray-600 text-sm">Transaksi berhasil ditambahkan</p>
                  </div>

                  <div class="bg-green-50 border border-green-200 rounded-xl p-4 mb-6">
                      <div class="flex items-center space-x-3">
                          <i class="fas fa-check-circle text-green-500 text-xl"></i>
                          <div>
                              <h5 class="font-semibold text-green-800">Penukaran Berhasil!</h5>
                              <p class="text-green-600 text-sm">E-wallet telah ditambahkan ke akun Anda</p>
                          </div>
                      </div>
                  </div>

                  <div class="bg-gray-50 rounded-xl p-4 mb-6">
                      <h6 class="font-semibold text-gray-800 mb-3">Detail Transaksi:</h6>
                      <div class="space-y-2 text-sm">
                          <div class="flex justify-between">
                              <span class="text-gray-600">ID Transaksi:</span>
                              <span id="transactionId" class="font-mono text-gray-800">TRX-001</span>
                          </div>
                          <div class="flex justify-between">
                              <span class="text-gray-600">Tanggal:</span>
                              <span id="transactionDate" class="text-gray-800">-</span>
                          </div>
                          <div class="flex justify-between">
                              <span class="text-gray-600">Status:</span>
                              <span class="text-green-600 font-semibold">Berhasil</span>
                          </div>
                      </div>
                  </div>

                  <button onclick="closeEwalletModal()" 
                          class="w-full bg-gradient-to-r from-blue-500 to-purple-600 text-white py-3 rounded-xl font-semibold hover:from-blue-600 hover:to-purple-700 transition-all duration-200">
                      Selesai
                  </button>
              </div>
          </div>
      </div>
  </div>

  <!-- Progress Bar -->
  <div class="fixed top-0 left-0 w-full h-1 bg-gray-200 z-50">
      <div id="progressBar" class="h-full bg-gradient-to-r from-blue-500 to-purple-600 transition-all duration-500" style="width: 0%"></div>
  </div>

  <script>
  // E-Wallet Modal Functions
  let currentStep = 1;
  let ewalletData = {
      amount: 0,
      points: 0,
      adminFee: 0
  };

  function openEwalletModal() {
      document.getElementById('ewalletModal').classList.remove('hidden');
      document.body.style.overflow = 'hidden';
      resetEwalletModal();
      updateProgressBar();
  }

  function closeEwalletModal() {
      document.getElementById('ewalletModal').classList.add('hidden');
      document.body.style.overflow = 'auto';
      resetEwalletModal();
  }

  function resetEwalletModal() {
      currentStep = 1;
      ewalletData = { amount: 0, points: 0, adminFee: 0 };
      
      // Reset input
      document.getElementById('ewalletAmount').value = '';
      
      // Show step 1, hide others
      document.getElementById('step1').classList.remove('hidden');
      document.getElementById('step2').classList.add('hidden');
      document.getElementById('step3').classList.add('hidden');
      
      // Reset progress bar
      updateProgressBar();
      
      // Reset button state
      document.getElementById('nextStep1Btn').disabled = true;
      document.getElementById('nextStep1Btn').classList.add('opacity-50', 'cursor-not-allowed');
  }

  function updateProgressBar() {
      const progress = (currentStep / 3) * 100;
      document.getElementById('progressBar').style.width = progress + '%';
  }

  function nextToStep2() {
      const amount = parseInt(document.getElementById('ewalletAmount').value);
      if (!amount || amount <= 0) {
          alert('Masukkan nominal yang valid');
          return;
      }

      // Calculate points needed (1 poin = Rp 100)
      const pointsNeeded = Math.ceil(amount / 100);
      const adminFee = Math.ceil(amount * 0.05); // 5% admin fee
      const totalPoints = pointsNeeded + Math.ceil(adminFee / 100);

      // Check if user has enough points
      const userPoints = parseInt(document.getElementById('totalPoints').textContent) || 0;
      if (totalPoints > userPoints) {
          alert('Poin tidak mencukupi untuk penukaran ini');
          return;
      }

      // Store data
      ewalletData = {
          amount: amount,
          points: totalPoints,
          adminFee: adminFee
      };

      // Update confirmation display
      document.getElementById('confirmAmount').textContent = `Rp ${amount.toLocaleString()}`;
      document.getElementById('confirmPoints').textContent = `${totalPoints} poin`;
      document.getElementById('confirmTotal').textContent = `Rp ${(amount + adminFee).toLocaleString()}`;

      // Show step 2
      currentStep = 2;
      document.getElementById('step1').classList.add('hidden');
      document.getElementById('step2').classList.remove('hidden');
      updateProgressBar();
  }

  function backToStep1() {
      currentStep = 1;
      document.getElementById('step2').classList.add('hidden');
      document.getElementById('step1').classList.remove('hidden');
      updateProgressBar();
  }

  function confirmExchange() {
      // Simulate API call
      const transactionId = 'TRX-' + Date.now().toString().slice(-6);
      const transactionDate = new Date().toLocaleDateString('id-ID', {
          year: 'numeric',
          month: 'long',
          day: 'numeric',
          hour: '2-digit',
          minute: '2-digit'
      });

      // Update transaction details
      document.getElementById('transactionId').textContent = transactionId;
      document.getElementById('transactionDate').textContent = transactionDate;

      // Show step 3
      currentStep = 3;
      document.getElementById('step2').classList.add('hidden');
      document.getElementById('step3').classList.remove('hidden');
      updateProgressBar();

      // Update user points (simulate)
      const currentPoints = parseInt(document.getElementById('totalPoints').textContent) || 0;
      const newPoints = currentPoints - ewalletData.points;
      document.getElementById('totalPoints').textContent = newPoints;

      // Add to transaction history
      addToTransactionHistory(transactionId, ewalletData.amount, ewalletData.points, transactionDate);
  }

  function addToTransactionHistory(id, amount, points, date) {
      // Get existing history or create new
      let history = JSON.parse(localStorage.getItem('ewalletHistory') || '[]');
      
      // Add new transaction
      history.unshift({
          id: id,
          amount: amount,
          points: points,
          date: date,
          status: 'Berhasil',
          type: 'E-Wallet'
      });

      // Save to localStorage
      localStorage.setItem('ewalletHistory', JSON.stringify(history));
  }

  // Real-time calculation for step 1
  document.addEventListener('DOMContentLoaded', function() {
      const amountInput = document.getElementById('ewalletAmount');
      if (amountInput) {
          amountInput.addEventListener('input', function() {
              const amount = parseInt(this.value) || 0;
              const pointsNeeded = Math.ceil(amount / 100);
              const adminFee = Math.ceil(amount * 0.05);
              const totalPoints = pointsNeeded + Math.ceil(adminFee / 100);
              
              const userPoints = parseInt(document.getElementById('totalPoints').textContent) || 0;
              const remainingPoints = userPoints - totalPoints;

              // Update display
              document.getElementById('pointsToExchange').textContent = `${totalPoints} poin`;
              document.getElementById('remainingPoints').textContent = `${remainingPoints} poin`;

              // Enable/disable button
              const nextBtn = document.getElementById('nextStep1Btn');
              if (amount > 0 && totalPoints <= userPoints) {
                  nextBtn.disabled = false;
                  nextBtn.classList.remove('opacity-50', 'cursor-not-allowed');
              } else {
                  nextBtn.disabled = true;
                  nextBtn.classList.add('opacity-50', 'cursor-not-allowed');
              }
          });
      }
  });

  // Close modal when clicking outside
  document.getElementById('ewalletModal').addEventListener('click', function(e) {
      if (e.target === this) {
          closeEwalletModal();
      }
  });
  </script>
@endsection

