@extends('layouts.app')

@section('content')
<style>
    html, body { 
        overflow-x: hidden; 
        margin: 0;
        padding: 0;
        scroll-behavior: smooth;
    }
    .sidebar-gradient { background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%); }
    .sidebar-hover { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
    .sidebar-item-hover { transition: all 0.2s ease-in-out; }
    .sidebar-item-hover:hover { background-color: rgba(255, 255, 255, 0.2); }
    .sidebar-logo { transition: all 0.3s ease-in-out; }
    .sidebar-nav-item { transition: all 0.2s ease-in-out; border-radius: 8px; }
    .sidebar-nav-item:hover { background-color: rgba(255, 255, 255, 0.1); }
    .sidebar-nav-item.active { background-color: rgba(255, 255, 255, 0.2); box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); }
    .fixed-header {
        position: fixed; top: 0; left: 0; right: 0; height: 48px; z-index: 40;
        display: flex; align-items: center; justify-content: space-between; 
        padding: 0 1.5rem; background: linear-gradient(135deg, #75E6DA 0%, #05445E 63%);
        transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
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
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.5); z-index: 45; opacity: 0; visibility: hidden;
        transition: all 0.3s ease;
    }
    .sidebar-overlay.active { opacity: 1; visibility: visible; }
    
    .text-highlight {
        color: #75E6DA;
    }
    
    .btn-primary {
        background: linear-gradient(135deg, #10B981, #059669);
        color: white;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
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
    }
    
    .btn-secondary:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(5, 68, 94, 0.4);
    }

    .stat-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

    .activity-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
    }

    .activity-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .quick-action-btn {
        background: linear-gradient(135deg, #75E6DA, #05445E);
        color: white;
        border: none;
        border-radius: 12px;
        padding: 1rem;
        transition: all 0.3s ease;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(117, 230, 218, 0.3);
    }

    .quick-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(117, 230, 218, 0.4);
    }

    .progress-bar {
        background: linear-gradient(90deg, #75E6DA, #05445E);
        height: 8px;
        border-radius: 4px;
        transition: width 0.3s ease;
    }

    .chart-container {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        border-radius: 16px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
    }

    /* Custom styles for nasabah dashboard */
    .notif-cards {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 25px;
        margin-bottom: 40px;
    }

    .card {
        background: white;
        border-radius: 16px;
        padding: 25px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
        position: relative;
        overflow: hidden;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }

    .card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #75E6DA, #05445E);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .card:hover::before {
        opacity: 1;
    }

    .card h4 {
        color: #0a3a60;
        font-weight: 600;
        font-size: 17px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card h4 i {
        color: #05445E;
        font-size: 20px;
    }

    .card p {
        font-size: 15px;
        color: #555;
        margin-bottom: 20px;
        line-height: 1.6;
    }

    .card-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 13px;
        color: #777;
    }

    .card-actions {
        display: flex;
        gap: 10px;
    }

    .card-btn {
        background: none;
        border: none;
        color: #05445E;
        cursor: pointer;
        font-size: 14px;
        padding: 4px 8px;
        border-radius: 4px;
        transition: all 0.2s;
    }

    .card-btn:hover {
        background: rgba(5, 68, 94, 0.1);
    }

    .card-btn.delete:hover {
        color: #FF5A5F;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 8px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-primary {
        background-color: #e1f0fa;
        color: #05445E;
    }

    .badge-success {
        background-color: #e6f7ed;
        color: #10B981;
    }

    .badge-warning {
        background-color: #fff4e6;
        color: #f97316;
    }

    /* Chart styles */
    .chart-section {
        background: white;
        padding: 30px;
        border-radius: 16px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        margin-bottom: 30px;
    }

    .chart-title {
        color: #0a3a60;
        font-weight: 700;
        font-size: 22px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .chart-title i {
        color: #05445E;
        font-size: 24px;
    }

    .chart-sub {
        font-size: 15px;
        color: #777;
        margin-bottom: 30px;
    }
    
    .chart-content {
        display: flex;
        align-items: flex-end;
        justify-content: space-around;
        position: relative;
        height: 220px;
        padding-top: 40px;
        padding-bottom: 30px;
    }

    .chart-content::before {
        content: '';
        position: absolute;
        bottom: 30px;
        left: 0;
        width: 100%;
        height: 2px;
        background: #eee;
    }

    .chart-bar-item {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        min-width: 0;
        position: relative;
        height: var(--height);
        transition: height 0.3s ease;
    }

    .bar {
        width: 100%;
        max-width: 50px;
        background: linear-gradient(to top, #05445E, #189AB4);
        border-radius: 8px 8px 0 0;
        position: relative;
        height: 100%;
        transform: scaleY(0);
        transform-origin: bottom;
        animation: grow-scale 1.5s ease-out forwards;
        animation-delay: calc(var(--order) * 0.2s);
    }

    @keyframes grow-scale {
        from { transform: scaleY(0); }
        to { transform: scaleY(1); }
    }

    .bar-label {
        position: absolute;
        top: -40px;
        left: 50%;
        transform: translateX(-50%);
        font-size: 13px;
        font-weight: 600;
        background: white;
        padding: 6px 12px;
        border-radius: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        white-space: nowrap;
        opacity: 0;
        animation: fadeIn 0.5s ease-out forwards;
        animation-delay: calc(var(--order) * 0.2s + 1s);
        color: #05445E;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateX(-50%) translateY(10px); }
        to { opacity: 1; transform: translateX(-50%) translateY(0); }
    }
    
    .day {
        position: absolute;
        bottom: -40px;
        width: 100%;
        text-align: center;
        font-size: 12px;
        color: #555;
    }

    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
        z-index: 1000;
        justify-content: center;
        align-items: center;
        backdrop-filter: blur(4px);
    }

    .modal-content {
        background: white;
        border-radius: 20px;
        width: 90%;
        max-width: 400px;
        padding: 0;
        box-shadow: 0 25px 50px rgba(0,0,0,0.25);
        animation: modalFadeIn 0.3s ease-out;
        overflow: hidden;
    }

    @keyframes modalFadeIn {
        from { 
            opacity: 0; 
            transform: translateY(-30px) scale(0.95); 
        }
        to { 
            opacity: 1; 
            transform: translateY(0) scale(1); 
        }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 20px 24px 16px 24px;
        border-bottom: 1px solid #e5e7eb;
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 50%);
    }

    .modal-title {
        font-size: 18px;
        color: #05445E;
        font-weight: 700;
    }

    .close-modal {
        background: none;
        border: none;
        font-size: 20px;
        cursor: pointer;
        color: #6b7280;
        transition: all 0.3s ease;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .close-modal:hover {
        color: #05445E;
        background-color: #f3f4f6;
        transform: scale(1.1);
    }

    .modal-body {
        padding: 0 24px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: #555;
    }

    .form-group input, 
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 15px;
        transition: all 0.3s;
    }

    .form-group input:focus, 
    .form-group textarea:focus {
        border-color: #75E6DA;
        outline: none;
        box-shadow: 0 0 0 3px rgba(117, 230, 218, 0.2);
    }

    .modal-footer {
        display: flex;
        justify-content: center;
        gap: 15px;
        padding: 20px 24px 24px 24px;
        border-top: 1px solid #e5e7eb;
        background: #f9fafb;
    }

    /* Notification Modal Styles */
    .notification-modal-item {
        display: flex;
        align-items: flex-start;
        padding: 20px;
        border-bottom: 1px solid #e5e7eb;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .notification-modal-item:hover {
        background-color: #f8fafc;
    }

    .notification-modal-item:last-child {
        border-bottom: none;
    }

    .notification-modal-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        margin-right: 16px;
        flex-shrink: 0;
    }

    .notification-modal-content {
        flex: 1;
    }

    .notification-modal-title {
        font-weight: 600;
        color: #05445E;
        margin-bottom: 4px;
        font-size: 1.1rem;
    }

    .notification-modal-message {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 8px;
    }

    .notification-modal-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.85rem;
        color: #888;
    }

    .notification-modal-badge {
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 500;
    }

    .notification-modal-badge.urgent {
        background-color: #fee2e2;
        color: #dc2626;
    }

    .notification-modal-badge.medium {
        background-color: #dcfce7;
        color: #16a34a;
    }

    .notification-modal-badge.low {
        background-color: #fef3c7;
        color: #d97706;
    }

    /* Search Modal Styles */
    .search-result-item {
        display: flex;
        align-items: center;
        padding: 12px;
        border-bottom: 1px solid #e5e7eb;
        transition: all 0.3s ease;
        cursor: pointer;
        border-radius: 8px;
        margin-bottom: 6px;
    }

    .search-result-item:hover {
        background-color: #f8fafc;
        transform: translateX(4px);
    }

    .search-result-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1rem;
        margin-right: 12px;
        flex-shrink: 0;
    }

    .search-result-content {
        flex: 1;
    }

    .search-result-title {
        font-weight: 600;
        color: #05445E;
        margin-bottom: 2px;
        font-size: 0.95rem;
    }

    .search-result-description {
        color: #666;
        font-size: 0.85rem;
        line-height: 1.3;
        margin-bottom: 4px;
    }

    .search-result-category {
        display: inline-block;
        padding: 2px 6px;
        border-radius: 8px;
        font-size: 0.7rem;
        font-weight: 500;
        margin-top: 2px;
    }

    .search-result-category.product {
        background-color: #dcfce7;
        color: #16a34a;
    }

    .search-result-category.service {
        background-color: #dbeafe;
        color: #2563eb;
    }

    .search-result-category.info {
        background-color: #fef3c7;
        color: #d97706;
    }

    .search-empty-state {
        text-align: center;
        padding: 40px 20px;
    }

    .search-empty-state i {
        font-size: 3rem;
        color: #d1d5db;
        margin-bottom: 16px;
    }

    .search-loading {
        text-align: center;
        padding: 20px;
    }

    .search-loading .spinner {
        border: 3px solid #f3f4f6;
        border-top: 3px solid #3b82f6;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        animation: spin 1s linear infinite;
        margin: 0 auto 16px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .btn {
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
    }

    .btn-primary {
        background: linear-gradient(135deg, #05445E 0%, #0A3A60 100%);
        color: white;
        padding: 12px 32px;
        font-weight: 600;
        border-radius: 12px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #0A3A60 0%, #05445E 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(5, 68, 94, 0.4);
    }

    .btn-outline {
        background: white;
        border: 1px solid #ddd;
        color: #555;
    }

    .btn-outline:hover {
        background: #f5f5f5;
    }

    .btn-danger {
        background: #FF5A5F;
        color: white;
    }

    .btn-danger:hover {
        background: #e04a50;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 90, 95, 0.3);
    }

    /* Quick Action Cards */
    .quick-action-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        cursor: pointer;
        border: 1px solid rgba(255, 255, 255, 0.3);
        position: relative;
        overflow: hidden;
    }

    .quick-action-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }

    .quick-action-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, #75E6DA, #05445E);
        opacity: 0;
        transition: opacity 0.3s;
    }

    .quick-action-card:hover::before {
        opacity: 1;
    }

    .quick-action-icon {
        width: 60px;
        height: 60px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
        margin-bottom: 16px;
    }

    .quick-action-title {
        font-size: 16px;
        font-weight: 600;
        color: #0a3a60;
        margin-bottom: 8px;
    }

    .quick-action-desc {
        font-size: 14px;
        color: #666;
        line-height: 1.5;
    }

    /* Education Cards */
    .education-card {
        background: white;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.3);
        position: relative;
        overflow: hidden;
    }

    .education-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }

    .education-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 20px;
        margin-bottom: 16px;
    }

    .education-title {
        font-size: 16px;
        font-weight: 600;
        color: #0a3a60;
        margin-bottom: 8px;
    }

    .education-desc {
        font-size: 14px;
        color: #666;
        line-height: 1.5;
        margin-bottom: 16px;
    }

    .education-btn {
        background: linear-gradient(135deg, #75E6DA, #05445E);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .education-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(117, 230, 218, 0.3);
    }

    /* Event Cards */
    .event-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        border: 1px solid rgba(255, 255, 255, 0.3);
        display: flex;
        gap: 16px;
        position: relative;
        overflow: hidden;
    }

    .event-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.1);
    }

    .event-date {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-width: 60px;
        padding: 12px 8px;
        background: linear-gradient(135deg, #75E6DA, #05445E);
        border-radius: 12px;
        color: white;
        text-align: center;
    }

    .event-day {
        font-size: 20px;
        font-weight: 700;
        line-height: 1;
    }

    .event-month {
        font-size: 12px;
        font-weight: 500;
        opacity: 0.9;
    }

    .event-content {
        flex: 1;
    }

    .event-title {
        font-size: 16px;
        font-weight: 600;
        color: #0a3a60;
        margin-bottom: 8px;
    }

    .event-desc {
        font-size: 14px;
        color: #666;
        line-height: 1.5;
        margin-bottom: 12px;
    }

    .event-meta {
        display: flex;
        flex-direction: column;
        gap: 4px;
        margin-bottom: 12px;
    }

    .event-time, .event-location {
        font-size: 12px;
        color: #888;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .event-btn {
        background: linear-gradient(135deg, #75E6DA, #05445E);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .event-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(117, 230, 218, 0.3);
    }

    /* Animations */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    @keyframes bounce {
        0%, 20%, 53%, 80%, 100% {
            transform: translate3d(0,0,0);
        }
        40%, 43% {
            transform: translate3d(0, -30px, 0);
        }
        70% {
            transform: translate3d(0, -15px, 0);
        }
        90% {
            transform: translate3d(0, -4px, 0);
        }
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }

    .animate-slide-in-left {
        animation: slideInLeft 0.6s ease-out;
    }

    .animate-pulse {
        animation: pulse 2s infinite;
    }

    .animate-bounce {
        animation: bounce 1s;
    }

    /* Hover effects for cards */
    .quick-action-card:hover .quick-action-icon {
        animation: pulse 0.6s ease-in-out;
    }

    .education-card:hover .education-icon {
        animation: bounce 0.6s ease-in-out;
    }

    .event-card:hover .event-date {
        animation: pulse 0.6s ease-in-out;
    }

    /* Loading animation */
    .loading-spinner {
        border: 3px solid #f3f4f6;
        border-top: 3px solid #3b82f6;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Responsive fixes */
    @media (max-width: 1024px) {
        .main-content-wrapper { padding-left: 1rem; padding-right: 1rem; }
        .content-container { padding: 1.5rem; }
    }
    @media (max-width: 768px) {
        .main-content-wrapper { padding-left: 0.5rem; padding-right: 0.5rem; }
        .content-container { padding: 1rem; }
        .notif-cards {
            grid-template-columns: 1fr;
        }
        .event-card {
            flex-direction: column;
            text-align: center;
        }
        .event-date {
            align-self: center;
        }
    }
</style>

<div class="flex min-h-screen bg-gray-50" x-data="{ sidebarOpen: false }">
    {{-- Sidebar Overlay --}}
    <div class="sidebar-overlay" :class="{ 'active': sidebarOpen }" @click="sidebarOpen = false"></div>

    @include('partials.sidebar-nasabah', ['active' => 'dashboard'])

    {{-- Main Content Area --}}
    <div class="main-content-wrapper">
        {{-- Top Header Bar --}}
        <div class="fixed-header">
            <h1 class="text-white font-semibold text-lg">BijakSampah</h1>
            <div class="flex items-center gap-4">
                <button onclick="showNotificationModal()" class="relative hover:text-white/80 transition-colors">
                    <i class="far fa-bell text-white text-sm"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-medium">2</span>
                </button>
                <button onclick="showSearchModal()" class="focus:outline-none hover:text-white/80 transition-colors">
                    <i class="fas fa-search text-white text-sm"></i>
                </button>
                <div class="flex items-center gap-2">
                    <button onclick="showDevelopmentModal('Profile')" class="w-8 h-8 rounded-full overflow-hidden flex items-center justify-center border-2 border-gray-300 cursor-pointer hover:border-white/50 transition-colors">
                        <img src="https://ui-avatars.com/api/?name=Non+Nasabah&background=75E6DA&color=05445E" alt="Profile" class="w-full h-full object-cover">
                    </button>
                </div>
            </div>
        </div>
        
        {{-- Content Container --}}
        <div class="content-container">
            {{-- Welcome Section --}}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-gray-800">Dashboard - Nasabah</h1>
                <p class="text-sm text-gray-500">Selamat datang di marketplace daur ulang</p>
            </div>

            {{-- Notifikasi Section --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Notifikasi</h2>
                <div class="notif-cards" id="notifContainer">
                    <!-- Notifikasi akan dimuat di sini -->
                </div>
            </div>

            {{-- Quick Actions Panel --}}
            <div class="mb-8 animate-fade-in-up">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Aksi Cepat</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div class="quick-action-card" onclick="navigateTo('sampahnasabah')">
                        <div class="quick-action-icon bg-gradient-to-br from-green-400 to-green-600">
                            <i class="fas fa-trash-alt"></i>
                        </div>
                        <div class="quick-action-content">
                            <h3 class="quick-action-title">Jadwalkan Penjemputan</h3>
                            <p class="quick-action-desc">Atur jadwal penjemputan sampah</p>
                        </div>
                    </div>
                    
                    <div class="quick-action-card" onclick="navigateTo('poin-nasabah')">
                        <div class="quick-action-icon bg-gradient-to-br from-yellow-400 to-yellow-600">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="quick-action-content">
                            <h3 class="quick-action-title">Tukar Poin</h3>
                            <p class="quick-action-desc">Tukar poin dengan hadiah</p>
                        </div>
                    </div>
                    
                    <div class="quick-action-card" onclick="navigateTo('tokon')">
                        <div class="quick-action-icon bg-gradient-to-br from-blue-400 to-blue-600">
                            <i class="fas fa-store"></i>
                        </div>
                        <div class="quick-action-content">
                            <h3 class="quick-action-title">Marketplace</h3>
                            <p class="quick-action-desc">Beli produk ramah lingkungan</p>
                        </div>
                    </div>
                    
                    <div class="quick-action-card" onclick="navigateTo('nasabahkomunitas')">
                        <div class="quick-action-icon bg-gradient-to-br from-purple-400 to-purple-600">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="quick-action-content">
                            <h3 class="quick-action-title">Komunitas</h3>
                            <p class="quick-action-desc">Bergabung dengan komunitas</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Progress & Stats Section --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8 animate-slide-in-left">
                {{-- Environmental Impact --}}
                <div class="stat-card p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Dampak Lingkungan</h3>
                        <i class="fas fa-leaf text-green-500 text-xl"></i>
                    </div>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">CO2 Tersimpan</span>
                            <span class="text-lg font-bold text-green-600">2.4 kg</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Pohon Setara</span>
                            <span class="text-lg font-bold text-green-600">0.12</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Air Tersimpan</span>
                            <span class="text-lg font-bold text-blue-600">15 L</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Target Bulanan</span>
                            <span class="text-green-600 font-medium">75%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2 mt-2">
                            <div class="bg-green-500 h-2 rounded-full" style="width: 75%"></div>
                        </div>
                    </div>
                </div>

                {{-- Rewards & Achievements --}}
                <div class="stat-card p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Pencapaian</h3>
                        <i class="fas fa-trophy text-yellow-500 text-xl"></i>
                    </div>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-check text-green-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">Pemula Hijau</p>
                                <p class="text-xs text-gray-500">Selesaikan 5 penjemputan</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-star text-blue-600 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-800">Konsisten</p>
                                <p class="text-xs text-gray-500">3 minggu berturut-turut</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 opacity-50">
                            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                <i class="fas fa-lock text-gray-400 text-sm"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-400">Eco Warrior</p>
                                <p class="text-xs text-gray-400">Selesaikan 20 penjemputan</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-600">Pencapaian berikutnya dalam <span class="font-medium text-blue-600">3 hari</span></p>
                    </div>
                </div>

                {{-- Community Stats --}}
                <div class="stat-card p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Komunitas</h3>
                        <i class="fas fa-users text-purple-500 text-xl"></i>
                    </div>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total Anggota</span>
                            <span class="text-lg font-bold text-purple-600">1,247</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Aktif Hari Ini</span>
                            <span class="text-lg font-bold text-green-600">89</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Peringkat Anda</span>
                            <span class="text-lg font-bold text-blue-600">#156</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <button onclick="navigateTo('nasabahkomunitas')" class="w-full bg-purple-500 hover:bg-purple-600 text-white py-2 px-4 rounded-lg text-sm font-medium transition-colors">
                            Lihat Komunitas
                        </button>
                    </div>
                </div>
            </div>

            {{-- Tips & Education Section --}}
            <div class="mb-8 animate-fade-in-up">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Tips & Edukasi</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="education-card">
                        <div class="education-icon bg-gradient-to-br from-green-400 to-green-600">
                            <i class="fas fa-recycle"></i>
                        </div>
                        <div class="education-content">
                            <h3 class="education-title">Cara Memilah Sampah</h3>
                            <p class="education-desc">Pelajari cara memilah sampah organik dan anorganik dengan benar</p>
                            <button class="education-btn" onclick="showEducationModal('pemilahan')">
                                Pelajari Lebih Lanjut
                            </button>
                        </div>
                    </div>
                    
                    <div class="education-card">
                        <div class="education-icon bg-gradient-to-br from-blue-400 to-blue-600">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <div class="education-content">
                            <h3 class="education-title">Ide Daur Ulang Kreatif</h3>
                            <p class="education-desc">Temukan ide kreatif untuk mendaur ulang sampah di rumah</p>
                            <button class="education-btn" onclick="showEducationModal('kreatif')">
                                Lihat Ide
                            </button>
                        </div>
                    </div>
                    
                    <div class="education-card">
                        <div class="education-icon bg-gradient-to-br from-purple-400 to-purple-600">
                            <i class="fas fa-chart-line"></i>
                        </div>
                        <div class="education-content">
                            <h3 class="education-title">Impact Report</h3>
                            <p class="education-desc">Lihat laporan dampak lingkungan dari aktivitas Anda</p>
                            <button class="education-btn" onclick="showEducationModal('impact')">
                                Lihat Laporan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Upcoming Events --}}
            <div class="mb-8 animate-slide-in-left">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">Event Mendatang</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="event-card">
                        <div class="event-date">
                            <span class="event-day">25</span>
                            <span class="event-month">Jun</span>
                        </div>
                        <div class="event-content">
                            <h3 class="event-title">Workshop Daur Ulang</h3>
                            <p class="event-desc">Workshop membuat kerajinan dari sampah plastik</p>
                            <div class="event-meta">
                                <span class="event-time"><i class="fas fa-clock"></i> 14:00 WIB</span>
                                <span class="event-location"><i class="fas fa-map-marker-alt"></i> Online</span>
                            </div>
                            <button class="event-btn" onclick="joinEvent('workshop')">
                                Daftar Sekarang
                            </button>
                        </div>
                    </div>
                    
                    <div class="event-card">
                        <div class="event-date">
                            <span class="event-day">30</span>
                            <span class="event-month">Jun</span>
                        </div>
                        <div class="event-content">
                            <h3 class="event-title">Challenges Hijau</h3>
                            <p class="event-desc">Kompetisi daur ulang dengan hadiah menarik</p>
                            <div class="event-meta">
                                <span class="event-time"><i class="fas fa-clock"></i> 09:00 WIB</span>
                                <span class="event-location"><i class="fas fa-map-marker-alt"></i> Offline</span>
                            </div>
                            <button class="event-btn" onclick="joinEvent('challenge')">
                                Ikut Challenge
                            </button>
                        </div>
                    </div>
                    
                    <div class="event-card">
                        <div class="event-date">
                            <span class="event-day">05</span>
                            <span class="event-month">Jul</span>
                        </div>
                        <div class="event-content">
                            <h3 class="event-title">Webinar Lingkungan</h3>
                            <p class="event-desc">Diskusi tentang solusi masalah sampah</p>
                            <div class="event-meta">
                                <span class="event-time"><i class="fas fa-clock"></i> 19:00 WIB</span>
                                <span class="event-location"><i class="fas fa-map-marker-alt"></i> Online</span>
                            </div>
                            <button class="event-btn" onclick="joinEvent('webinar')">
                                Daftar Webinar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Aktivitas Section --}}
            <div class="chart-section">
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800 mb-2">Aktivitasmu</h2>
                        <p class="text-sm text-gray-500">Minggu Lalu</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold">
                            Hurraaahhh! Super Productive
                        </div>
                        <div class="text-2xl font-bold text-green-600">97%</div>
                        <button class="bg-gray-100 hover:bg-gray-200 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            Bulan <i class="fas fa-chevron-down ml-1"></i>
                        </button>
                    </div>
                </div>

                <div class="chart-content" id="chart-content">
                    <!-- Grafik akan dimuat di sini -->
                </div>
            </div>

            <div class="text-center mt-8 text-gray-500">
                Created by <strong>TEK(G)</strong> | All Right Reserved!
            </div>
        </div>
    </div>
</div>

{{-- Modal untuk menu dalam pengembangan --}}
<div class="modal" id="developmentModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Fitur Dalam Pengembangan</h3>
            <button class="close-modal" id="closeDevelopmentModal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="text-center py-6">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-tools text-blue-600 text-3xl"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-4">Fitur Sedang Dikembangkan</h4>
                <p class="text-gray-600 text-base leading-relaxed mb-6">
                    Fitur ini sedang dalam tahap pengembangan. 
                    Tim kami sedang bekerja keras untuk menghadirkan pengalaman terbaik untuk Anda.
                </p>
                <div class="bg-blue-50 rounded-xl p-4 mb-6">
                    <div class="flex items-center justify-center gap-2">
                        <i class="fas fa-clock text-blue-600"></i>
                        <span class="text-blue-600 font-medium">Estimasi rilis: 2-3 minggu ke depan</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" id="closeDevModal">Mengerti</button>
        </div>
    </div>
</div>

{{-- Modal untuk search yang sudah berfungsi --}}
<div class="modal" id="searchModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Pencarian</h3>
            <button class="close-modal" id="closeSearchModal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="mb-4">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari produk atau layanan..." 
                           class="w-full px-3 py-2 pl-10 border-2 border-gray-200 rounded-lg focus:border-blue-500 focus:outline-none transition-colors text-sm">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 text-sm"></i>
                </div>
            </div>
            <div id="searchResults">
                <!-- Hasil pencarian akan dimuat di sini -->
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" id="closeSearchBtn">Tutup</button>
        </div>
    </div>
</div>

{{-- Modal untuk notifikasi yang sudah ada --}}
<div class="modal" id="notificationModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Notifikasi</h3>
            <button class="close-modal" id="closeNotificationModal">&times;</button>
        </div>
        <div class="modal-body">
            <div id="notificationModalContent">
                <!-- Notifikasi akan dimuat di sini -->
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" id="closeNotifModal">Tutup</button>
        </div>
    </div>
</div>

{{-- Modal untuk fitur dalam pengembangan --}}
<div class="modal" id="featureModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Fitur Dalam Pengembangan</h3>
            <button class="close-modal" id="closeFeatureModal">&times;</button>
        </div>
        <div class="modal-body">
            <div class="text-center py-6">
                <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-tools text-blue-600 text-3xl"></i>
                </div>
                <h4 class="text-xl font-bold text-gray-900 mb-4">Fitur Sedang Dikembangkan</h4>
                <p class="text-gray-600 text-base leading-relaxed mb-6">
                    Fitur ini sedang dalam tahap pengembangan. 
                    Tim kami sedang bekerja keras untuk menghadirkan pengalaman terbaik untuk Anda.
                </p>
                <div class="bg-blue-50 rounded-xl p-4 mb-6">
                    <div class="flex items-center justify-center gap-2">
                        <i class="fas fa-clock text-blue-600"></i>
                        <span class="text-blue-600 font-medium">Estimasi rilis: 2-3 minggu ke depan</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" id="closeFeatureBtn">Mengerti</button>
        </div>
    </div>
</div>

<script>
    // Data Notifikasi sesuai gambar
    let notifications = [
        { 
            id: 1,
            title: "Koleksi Tas Daur Ulang Lucu",
            icon: "fas fa-shopping-bag",
            message: "Ramah lingkungan & stylish. Cek di Marketplace BijakSampah! ❤️",
            date: "22 Juni 2025",
            time: "20:45",
            priority: "Urgent",
            timeTag: "Kemarin"
        },
        { 
            id: 2,
            title: "Dompet daur ulang unik tersedia!",
            icon: "fas fa-wallet",
            message: "Anti air & ramah lingkungan. Cek di Marketplace BijakSampah! ❤️❤️❤️",
            date: "23 Juni 2025",
            time: "14:14",
            priority: "Medium",
            timeTag: "2 jam yang lalu"
        }
    ];

    // Data untuk grafik aktivitas sesuai gambar
    const chartData = [
        { height: 60, value: '60%', label: '16 Jun' }, 
        { height: 45, value: '45%', label: '17 Jun' }, 
        { height: 97, value: '97%', label: '18 Jun' },
        { height: 75, value: '75%', label: '19 Jun' }, 
        { height: 80, value: '80%', label: '20 Jun' }, 
        { height: 65, value: '65%', label: '21 Jun' }, 
        { height: 70, value: '70%', label: '22 Jun' }  
    ];

    // Data untuk search
    const searchData = [
        {
            id: 1,
            title: "Tas Daur Ulang",
            description: "Tas ramah lingkungan dengan desain menarik",
            category: "product",
            icon: "fas fa-shopping-bag",
            iconBg: "background: linear-gradient(135deg, #10B981, #059669);",
            price: "Rp 45.000"
        },
        {
            id: 2,
            title: "Penjemputan Sampah",
            description: "Layanan penjemputan sampah daur ulang",
            category: "service",
            icon: "fas fa-trash-alt",
            iconBg: "background: linear-gradient(135deg, #3B82F6, #2563EB);",
            price: "Gratis"
        },
        {
            id: 3,
            title: "Tukar Poin",
            description: "Tukar poin dengan hadiah menarik",
            category: "service",
            icon: "fas fa-coins",
            iconBg: "background: linear-gradient(135deg, #8B5CF6, #7C3AED);",
            price: "Mulai 100 poin"
        }
    ];

    // DOM Elements
    const notifContainer = document.getElementById('notifContainer');
    const chartContent = document.getElementById('chart-content');

    // Load Notifications
    function loadNotifications() {
        console.log('Loading notifications, count:', notifications.length);
        notifContainer.innerHTML = '';
        
        if (notifications.length === 0) {
            notifContainer.innerHTML = `
                <div class="col-span-full text-center py-8">
                    <i class="fas fa-bell-slash text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500">Tidak ada notifikasi</p>
                </div>
            `;
            return;
        }
        
        notifications.forEach(notif => {
            const card = document.createElement('div');
            card.className = 'card';
            
            // Priority badge color
            let priorityClass = '';
            if (notif.priority === 'Urgent') {
                priorityClass = 'bg-red-100 text-red-800';
            } else if (notif.priority === 'Medium') {
                priorityClass = 'bg-green-100 text-green-800';
            }
            
            card.innerHTML = `
                <div class="flex justify-between items-start mb-3">
                    <span class="badge badge-primary">${notif.timeTag}</span>
                    <div class="flex items-center gap-2">
                        <span class="badge ${priorityClass}">${notif.priority}</span>
                        <button class="card-btn delete" data-id="${notif.id}" onclick="deleteNotification(${notif.id})">
                            <i class="fas fa-trash text-red-500 hover:text-red-700"></i>
                        </button>
                    </div>
                </div>
                <h4><i class="${notif.icon}"></i> ${notif.title}</h4>
                <p>${notif.message}</p>
                <div class="card-footer">
                    <div class="flex items-center gap-2">
                        <i class="fas fa-calendar text-gray-400 text-xs"></i>
                        <span class="text-xs text-gray-500">${notif.date}</span>
                        <i class="fas fa-clock text-gray-400 text-xs"></i>
                        <span class="text-xs text-gray-500">${notif.time}</span>
                    </div>
                </div>
            `;
            notifContainer.appendChild(card);
        });

        // Update notification count
        updateNotificationCount();
    }

    // Generate Chart for activity trends
    function generateChart() {
        chartContent.innerHTML = '';
        
        // Generate bars for each day
        chartData.forEach((data, index) => {
            const chartBarItem = document.createElement('div');
            chartBarItem.className = 'chart-bar-item';
            chartBarItem.style.setProperty('--height', `${data.height}%`);
            
            // Add green color for the highest bar (18 Jun - 97%)
            let barClass = 'bar';
            if (data.height === 97) {
                barClass = 'bar green';
            }
            
            chartBarItem.innerHTML = `
                <div class="${barClass}" style="--order: ${index + 1};">
                    <span class="bar-label">${data.value} ${data.label}</span>
                </div>
                <div class="day">${data.label}</div>
            `;
            chartContent.appendChild(chartBarItem);
        });
    }

    // Update Notification Count in Topbar
    function updateNotificationCount() {
        const countElement = document.querySelector('.absolute.-top-1.-right-1');
        if (countElement) {
            countElement.textContent = notifications.length;
            if (notifications.length === 0) {
                countElement.style.display = 'none';
            } else {
                countElement.style.display = 'flex';
            }
        }
    }

    // Delete Notification
    function deleteNotification(id) {
        console.log('Deleting notification with ID:', id);
        
        // Create confirmation modal
        const confirmModal = document.createElement('div');
        confirmModal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center';
        confirmModal.innerHTML = `
            <div class="bg-white rounded-2xl p-8 max-w-md mx-4 text-center shadow-2xl">
                <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-trash text-red-600 text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Hapus Notifikasi</h3>
                <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus notifikasi ini?</p>
                <div class="flex gap-3 justify-center">
                    <button onclick="this.parentElement.parentElement.parentElement.remove()" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg font-medium hover:bg-gray-300 transition-colors">
                        Batal
                    </button>
                    <button onclick="confirmDeleteNotification(${id})" class="px-6 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition-colors">
                        Hapus
                    </button>
                </div>
            </div>
        `;
        document.body.appendChild(confirmModal);
    }

    // Confirm Delete Notification
    function confirmDeleteNotification(id) {
        // Remove confirmation modal
        const confirmModal = document.querySelector('.fixed.inset-0');
        if (confirmModal) {
            confirmModal.remove();
        }
        
        // Remove from notifications array
        const initialLength = notifications.length;
        notifications = notifications.filter(notif => notif.id !== id);
        
        console.log('Notifications before:', initialLength, 'after:', notifications.length);
        
        // Reload notifications display
        loadNotifications();
        
        // Show success message
        showToast('Notifikasi berhasil dihapus!', 'success');
        
        // Update notification count in topbar
        updateNotificationCount();
    }

    // Show Toast Message
    function showToast(message, type = 'success') {
        // Create toast element
        const toast = document.createElement('div');
        toast.className = `fixed top-6 right-6 z-50 max-w-sm w-full bg-white rounded-xl shadow-2xl border border-gray-200 transition-all duration-500 transform translate-x-full`;
        
        let iconClass = 'fas fa-check-circle';
        let bgColor = 'bg-green-50';
        let textColor = 'text-green-600';
        let borderColor = 'border-green-200';
        
        if (type === 'error') {
            iconClass = 'fas fa-exclamation-circle';
            bgColor = 'bg-red-50';
            textColor = 'text-red-600';
            borderColor = 'border-red-200';
        } else if (type === 'warning') {
            iconClass = 'fas fa-exclamation-triangle';
            bgColor = 'bg-yellow-50';
            textColor = 'text-yellow-600';
            borderColor = 'border-yellow-200';
        } else if (type === 'info') {
            iconClass = 'fas fa-info-circle';
            bgColor = 'bg-blue-50';
            textColor = 'text-blue-600';
            borderColor = 'border-blue-200';
        }
        
        toast.innerHTML = `
            <div class="p-4 ${bgColor} ${borderColor} rounded-xl">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="${iconClass} ${textColor} text-xl"></i>
                    </div>
                    <div class="ml-3 w-0 flex-1">
                        <p class="text-sm font-medium text-gray-900">${message}</p>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex">
                        <button onclick="this.parentElement.parentElement.parentElement.parentElement.remove()" class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-600 focus:outline-none">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(toast);
        
        // Animate in
        setTimeout(() => {
            toast.classList.remove('translate-x-full');
        }, 100);
        
        // Remove after 4 seconds
        setTimeout(() => {
            toast.classList.add('translate-x-full');
            setTimeout(() => {
                if (document.body.contains(toast)) {
                    document.body.removeChild(toast);
                }
            }, 500);
        }, 4000);
    }

    // Show Development Modal
    function showDevelopmentModal(featureName) {
        const modal = document.getElementById('developmentModal');
        const title = modal.querySelector('.modal-title');
        title.textContent = `${featureName} - Fitur Dalam Pengembangan`;
        
        // Update modal content based on feature
        const modalBody = modal.querySelector('.modal-body .text-center');
        let iconClass = 'fas fa-tools';
        let bgColor = 'bg-blue-100';
        let textColor = 'text-blue-600';
        
        if (featureName === 'Notification') {
            iconClass = 'fas fa-bell';
            bgColor = 'bg-green-100';
            textColor = 'text-green-600';
        } else if (featureName === 'Search') {
            iconClass = 'fas fa-search';
            bgColor = 'bg-purple-100';
            textColor = 'text-purple-600';
        } else if (featureName === 'Profile') {
            iconClass = 'fas fa-user';
            bgColor = 'bg-orange-100';
            textColor = 'text-orange-600';
        }
        
        modalBody.innerHTML = `
            <div class="w-20 h-20 ${bgColor} rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="${iconClass} ${textColor} text-3xl"></i>
            </div>
            <h4 class="text-xl font-bold text-gray-900 mb-4">Fitur Sedang Dikembangkan</h4>
            <p class="text-gray-600 text-base leading-relaxed mb-6">
                Fitur ${featureName} sedang dalam tahap pengembangan. 
                Tim kami sedang bekerja keras untuk menghadirkan pengalaman terbaik untuk Anda.
            </p>
            <div class="bg-blue-50 rounded-xl p-4 mb-6">
                <div class="flex items-center justify-center gap-2">
                    <i class="fas fa-clock text-blue-600"></i>
                    <span class="text-blue-600 font-medium">Estimasi rilis: 2-3 minggu ke depan</span>
                </div>
            </div>
        `;
        
        modal.style.display = 'flex';
        
        // Show toast notification
        setTimeout(() => {
            showHeaderActionNotification(featureName);
        }, 500);
    }

    // Show Activity Notification
    function showActivityNotification() {
        const activities = [
            'Anda telah mengumpulkan 150 poin hari ini!',
            'Selamat! Anda telah menyelesaikan 3 penjemputan sampah',
            'Poin Anda telah bertambah 25 poin',
            'Anda telah membantu menyelamatkan lingkungan!'
        ];
        
        const randomActivity = activities[Math.floor(Math.random() * activities.length)];
        showToast(randomActivity, 'success');
    }

    // Show Welcome Notification
    function showWelcomeNotification() {
        const welcomeMessages = [
            'Selamat datang kembali di BijakSampah!',
            'Terima kasih telah berkontribusi untuk lingkungan',
            'Mari kita jaga bumi bersama-sama!',
            'Aktivitas Anda hari ini sangat menginspirasi!'
        ];
        
        const randomMessage = welcomeMessages[Math.floor(Math.random() * welcomeMessages.length)];
        showToast(randomMessage, 'info');
    }

    // Show Header Action Notification
    function showHeaderActionNotification(action) {
        const notifications = {
            'Notification': {
                message: 'Anda memiliki 2 notifikasi baru',
                type: 'info',
                icon: 'fas fa-bell'
            },
            'Search': {
                message: 'Fitur pencarian sedang dalam pengembangan',
                type: 'warning',
                icon: 'fas fa-search'
            },
            'Profile': {
                message: 'Profil Anda sedang diperbarui',
                type: 'info',
                icon: 'fas fa-user'
            },
            'Profile Menu': {
                message: 'Menu profil sedang dalam pengembangan',
                type: 'warning',
                icon: 'fas fa-chevron-down'
            }
        };
        
        const notification = notifications[action];
        if (notification) {
            showToast(notification.message, notification.type);
        }
    }

    // Show Notification Modal
    function showNotificationModal() {
        const modal = document.getElementById('notificationModal');
        const modalContent = document.getElementById('notificationModalContent');
        
        // Generate notification modal content
        let modalHTML = '';
        
        if (notifications.length === 0) {
            modalHTML = `
                <div class="text-center py-12">
                    <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-bell-slash text-gray-400 text-2xl"></i>
                    </div>
                    <h4 class="text-lg font-semibold text-gray-600 mb-2">Tidak Ada Notifikasi</h4>
                    <p class="text-gray-500">Anda tidak memiliki notifikasi baru saat ini.</p>
                </div>
            `;
        } else {
            notifications.forEach(notif => {
                let iconBg = '';
                let badgeClass = '';
                
                if (notif.priority === 'Urgent') {
                    iconBg = 'background: linear-gradient(135deg, #EF4444, #DC2626);';
                    badgeClass = 'urgent';
                } else if (notif.priority === 'Medium') {
                    iconBg = 'background: linear-gradient(135deg, #10B981, #059669);';
                    badgeClass = 'medium';
                } else {
                    iconBg = 'background: linear-gradient(135deg, #F59E0B, #D97706);';
                    badgeClass = 'low';
                }
                
                modalHTML += `
                    <div class="notification-modal-item" onclick="viewNotification(${notif.id})">
                        <div class="notification-modal-icon" style="${iconBg}">
                            <i class="${notif.icon}"></i>
                        </div>
                        <div class="notification-modal-content">
                            <div class="notification-modal-title">${notif.title}</div>
                            <div class="notification-modal-message">${notif.message}</div>
                            <div class="notification-modal-meta">
                                <span class="notification-modal-badge ${badgeClass}">${notif.priority}</span>
                                <span><i class="fas fa-calendar text-xs"></i> ${notif.date}</span>
                                <span><i class="fas fa-clock text-xs"></i> ${notif.time}</span>
                            </div>
                        </div>
                    </div>
                `;
            });
        }
        
        modalContent.innerHTML = modalHTML;
        modal.style.display = 'flex';
    }

    // View Notification Details
    function viewNotification(id) {
        const notification = notifications.find(n => n.id === id);
        if (notification) {
            showToast(`Melihat detail: ${notification.title}`, 'info');
            // Here you can add more detailed view logic
        }
    }

    // Show Search Modal
    function showSearchModal() {
        const modal = document.getElementById('searchModal');
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        
        modal.style.display = 'flex';
        
        // Focus on search input
        setTimeout(() => {
            searchInput.focus();
        }, 300);
        
        // Show initial results
        displaySearchResults(searchData);
        
        // Add event listener for search input
        searchInput.addEventListener('input', function() {
            const query = this.value.toLowerCase();
            if (query.length > 0) {
                const filteredResults = searchData.filter(item => 
                    item.title.toLowerCase().includes(query) ||
                    item.description.toLowerCase().includes(query) ||
                    item.category.toLowerCase().includes(query)
                );
                displaySearchResults(filteredResults);
            } else {
                displaySearchResults(searchData);
            }
        });
    }

    // Display Search Results
    function displaySearchResults(results) {
        const searchResults = document.getElementById('searchResults');
        
        if (results.length === 0) {
            searchResults.innerHTML = `
                <div class="search-empty-state">
                    <i class="fas fa-search"></i>
                    <h4 class="text-lg font-semibold text-gray-600 mb-2">Tidak Ada Hasil</h4>
                    <p class="text-gray-500">Coba kata kunci yang berbeda</p>
                </div>
            `;
        } else {
            let resultsHTML = '';
            results.forEach(item => {
                resultsHTML += `
                    <div class="search-result-item" onclick="selectSearchResult(${item.id})">
                        <div class="search-result-icon" style="${item.iconBg}">
                            <i class="${item.icon}"></i>
                        </div>
                        <div class="search-result-content">
                            <div class="search-result-title">${item.title}</div>
                            <div class="search-result-description">${item.description}</div>
                            <div class="flex items-center justify-between mt-2">
                                <span class="search-result-category ${item.category}">${getCategoryLabel(item.category)}</span>
                                <span class="text-sm font-medium text-gray-600">${item.price}</span>
                            </div>
                        </div>
                    </div>
                `;
            });
            searchResults.innerHTML = resultsHTML;
        }
    }

    // Get Category Label
    function getCategoryLabel(category) {
        const labels = {
            'product': 'Produk',
            'service': 'Layanan',
            'info': 'Informasi'
        };
        return labels[category] || category;
    }

    // Select Search Result
    function selectSearchResult(id) {
        const item = searchData.find(item => item.id === id);
        if (item) {
            showToast(`Membuka: ${item.title}`, 'success');
            // Here you can add navigation logic
            document.getElementById('searchModal').style.display = 'none';
        }
    }

    // Close Development Modal
    document.getElementById('closeDevelopmentModal').addEventListener('click', function() {
        document.getElementById('developmentModal').style.display = 'none';
    });

    document.getElementById('closeDevModal').addEventListener('click', function() {
        document.getElementById('developmentModal').style.display = 'none';
    });

    // Close Notification Modal
    document.getElementById('closeNotificationModal').addEventListener('click', function() {
        document.getElementById('notificationModal').style.display = 'none';
    });

    document.getElementById('closeNotifModal').addEventListener('click', function() {
        document.getElementById('notificationModal').style.display = 'none';
    });

    // Close Search Modal
    document.getElementById('closeSearchModal').addEventListener('click', function() {
        document.getElementById('searchModal').style.display = 'none';
    });

    document.getElementById('closeSearchBtn').addEventListener('click', function() {
        document.getElementById('searchModal').style.display = 'none';
    });

    // Close Feature Modal
    document.getElementById('closeFeatureModal').addEventListener('click', function() {
        document.getElementById('featureModal').style.display = 'none';
    });

    document.getElementById('closeFeatureBtn').addEventListener('click', function() {
        document.getElementById('featureModal').style.display = 'none';
    });

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const developmentModal = document.getElementById('developmentModal');
        const notificationModal = document.getElementById('notificationModal');
        const searchModal = document.getElementById('searchModal');
        const featureModal = document.getElementById('featureModal');
        
        if (event.target === developmentModal) {
            developmentModal.style.display = 'none';
        }
        
        if (event.target === notificationModal) {
            notificationModal.style.display = 'none';
        }
        
        if (event.target === searchModal) {
            searchModal.style.display = 'none';
        }
        
        if (event.target === featureModal) {
            featureModal.style.display = 'none';
        }
    });

    // Navigation function
    function navigateTo(route) {
        // Show loading toast
        showToast('Mengalihkan ke halaman...', 'info');
        
        // Simulate navigation delay
        setTimeout(() => {
            // In a real app, this would navigate to the actual route
            if (route === 'sampahnasabah') {
                window.location.href = '/sampahnasabah';
            } else if (route === 'poin-nasabah') {
                window.location.href = '/poin-nasabah';
            } else if (route === 'tokon') {
                window.location.href = '/tokon';
            } else if (route === 'nasabahkomunitas') {
                window.location.href = '/nasabahkomunitas';
            } else {
                showToast('Fitur sedang dalam pengembangan', 'warning');
            }
        }, 1000);
    }

    // Show Education Modal
    function showEducationModal(type) {
        const educationData = {
            'pemilahan': {
                title: 'Cara Memilah Sampah',
                content: `
                    <div class="space-y-4">
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-800 mb-2">Sampah Organik</h4>
                            <ul class="text-sm text-green-700 space-y-1">
                                <li>• Sisa makanan</li>
                                <li>• Daun-daunan</li>
                                <li>• Kulit buah</li>
                                <li>• Kertas tisu</li>
                            </ul>
                        </div>
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-blue-800 mb-2">Sampah Anorganik</h4>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• Plastik</li>
                                <li>• Kertas</li>
                                <li>• Logam</li>
                                <li>• Kaca</li>
                            </ul>
                        </div>
                        <div class="bg-red-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-red-800 mb-2">Sampah B3</h4>
                            <ul class="text-sm text-red-700 space-y-1">
                                <li>• Baterai</li>
                                <li>• Lampu neon</li>
                                <li>• Obat-obatan</li>
                                <li>• Cat</li>
                            </ul>
                        </div>
                    </div>
                `
            },
            'kreatif': {
                title: 'Ide Daur Ulang Kreatif',
                content: `
                    <div class="space-y-4">
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-yellow-800 mb-2">Botol Plastik</h4>
                            <ul class="text-sm text-yellow-700 space-y-1">
                                <li>• Pot tanaman</li>
                                <li>• Tempat pensil</li>
                                <li>• Lampu hias</li>
                                <li>• Vertical garden</li>
                            </ul>
                        </div>
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-purple-800 mb-2">Kardus</h4>
                            <ul class="text-sm text-purple-700 space-y-1">
                                <li>• Organizer</li>
                                <li>• Mainan anak</li>
                                <li>• Dekorasi rumah</li>
                                <li>• Storage box</li>
                            </ul>
                        </div>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-green-800 mb-2">Kertas</h4>
                            <ul class="text-sm text-green-700 space-y-1">
                                <li>• Origami</li>
                                <li>• Paper mache</li>
                                <li>• Greeting cards</li>
                                <li>• Notebook</li>
                            </ul>
                        </div>
                    </div>
                `
            },
            'impact': {
                title: 'Impact Report',
                content: `
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-green-50 p-4 rounded-lg text-center">
                                <div class="text-2xl font-bold text-green-600">2.4 kg</div>
                                <div class="text-sm text-green-700">CO2 Tersimpan</div>
                            </div>
                            <div class="bg-blue-50 p-4 rounded-lg text-center">
                                <div class="text-2xl font-bold text-blue-600">15 L</div>
                                <div class="text-sm text-blue-700">Air Tersimpan</div>
                            </div>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-yellow-800 mb-2">Pencapaian Bulan Ini</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between">
                                    <span class="text-sm">Penjemputan Sampah</span>
                                    <span class="font-medium">8 kali</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm">Total Sampah</span>
                                    <span class="font-medium">24 kg</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm">Poin Terkumpul</span>
                                    <span class="font-medium">320 poin</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `
            }
        };

        const data = educationData[type];
        if (data) {
            showEducationContent(data.title, data.content);
        }
    }

    // Show Education Content Modal
    function showEducationContent(title, content) {
        const modal = document.createElement('div');
        modal.className = 'modal';
        modal.style.display = 'flex';
        modal.innerHTML = `
            <div class="modal-content" style="max-width: 600px;">
                <div class="modal-header">
                    <h3 class="modal-title">${title}</h3>
                    <button class="close-modal" onclick="this.parentElement.parentElement.parentElement.remove()">&times;</button>
                </div>
                <div class="modal-body">
                    ${content}
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="this.parentElement.parentElement.parentElement.remove()">Tutup</button>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
    }

    // Join Event Function
    function joinEvent(eventType) {
        const eventData = {
            'workshop': {
                title: 'Workshop Daur Ulang',
                message: 'Anda berhasil mendaftar untuk Workshop Daur Ulang pada 25 Juni 2025'
            },
            'challenge': {
                title: 'Challenges Hijau',
                message: 'Anda berhasil mendaftar untuk Challenges Hijau pada 30 Juni 2025'
            },
            'webinar': {
                title: 'Webinar Lingkungan',
                message: 'Anda berhasil mendaftar untuk Webinar Lingkungan pada 5 Juli 2025'
            }
        };

        const data = eventData[eventType];
        if (data) {
            showToast(data.message, 'success');
            
            // Add to notifications
            const newNotification = {
                id: Date.now(),
                title: `Daftar ${data.title}`,
                icon: 'fas fa-calendar-check',
                message: data.message,
                date: new Date().toLocaleDateString('id-ID'),
                time: new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' }),
                priority: 'Medium',
                timeTag: 'Baru saja'
            };
            
            notifications.unshift(newNotification);
            loadNotifications();
        }
    }

    // Real-time updates simulation
    function startRealTimeUpdates() {
        // Simulate real-time data updates
        setInterval(() => {
            // Update environmental impact randomly
            const co2Element = document.querySelector('.stat-card .text-green-600');
            if (co2Element && co2Element.textContent.includes('kg')) {
                const currentValue = parseFloat(co2Element.textContent);
                const newValue = currentValue + (Math.random() * 0.1);
                co2Element.textContent = newValue.toFixed(1) + ' kg';
            }
            
            // Update community stats
            const activeMembers = document.querySelector('.stat-card .text-green-600');
            if (activeMembers && activeMembers.textContent.includes('89')) {
                const currentActive = parseInt(activeMembers.textContent);
                const newActive = currentActive + Math.floor(Math.random() * 3) - 1;
                if (newActive > 0) {
                    activeMembers.textContent = newActive;
                }
            }
        }, 30000); // Update every 30 seconds
    }

    // Add achievement unlock animation
    function unlockAchievement(achievementName) {
        const achievementModal = document.createElement('div');
        achievementModal.className = 'fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center';
        achievementModal.innerHTML = `
            <div class="bg-white rounded-2xl p-8 max-w-md mx-4 text-center shadow-2xl animate-bounce">
                <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-trophy text-yellow-600 text-3xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">🎉 Achievement Unlocked!</h3>
                <p class="text-gray-600 mb-4">${achievementName}</p>
                <button onclick="this.parentElement.parentElement.remove()" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                    Keren!
                </button>
            </div>
        `;
        document.body.appendChild(achievementModal);
        
        // Remove modal after 3 seconds
        setTimeout(() => {
            if (document.body.contains(achievementModal)) {
                achievementModal.remove();
            }
        }, 3000);
    }

    // Add progress animation
    function animateProgress() {
        const progressBars = document.querySelectorAll('.bg-green-500');
        progressBars.forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.transition = 'width 2s ease-in-out';
                bar.style.width = width;
            }, 500);
        });
    }

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM loaded, initializing...');
        loadNotifications();
        generateChart();
        updateNotificationCount();
        
        // Start real-time updates
        startRealTimeUpdates();
        
        // Animate progress bars
        setTimeout(() => {
            animateProgress();
        }, 1000);
        
        // Add welcome toast
        setTimeout(() => {
            showWelcomeNotification();
        }, 1000);
        
        // Add activity notification after 3 seconds
        setTimeout(() => {
            showActivityNotification();
        }, 4000);
        
        // Simulate achievement unlock after 10 seconds
        setTimeout(() => {
            unlockAchievement('Pemula Hijau - Selesaikan 5 penjemputan');
        }, 10000);
    });
</script>
@endsection

