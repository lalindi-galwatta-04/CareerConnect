<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Management: <?php echo htmlspecialchars($course['title'] ?? 'EN2201 Entrepreneurship'); ?> - CareerConnect</title>
    <link rel="stylesheet" href="public/css/style.css?v=<?php echo time(); ?>">
    <style>
        :root {
            --cm-primary: #0284c7;
            --cm-navy: #092853;
            --cm-green: #15803d;
            --cm-green-light: #dcfce7;
            --cm-border: #cbd5e1;
            --cm-card-border: #e2e8f0;
            --cm-text-dark: #0f172a;
            --cm-text-muted: #64748b;
        }

        body {
            background-color: #f1f7fc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(2, 132, 199, 0.06) 0px, transparent 50%),
                radial-gradient(at 100% 30%, rgba(13, 148, 136, 0.05) 0px, transparent 50%),
                radial-gradient(at 50% 100%, rgba(9, 40, 83, 0.04) 0px, transparent 60%);
            min-height: 100vh;
            color: #1e293b;
            font-family: 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, Roboto, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Top Full-Width Navbar Matching Mockup */
        .cm-top-header {
            width: 100%;
            height: 72px;
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 45px;
            position: sticky;
            top: 0;
            z-index: 900;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        }

        .cm-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .cm-brand-logo {
            width: 32px;
            height: 32px;
            object-fit: contain;
        }

        .cm-brand-text {
            font-size: 1.35rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.02em;
        }

        .cm-brand-text span {
            color: #0284c7;
        }

        .cm-header-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .cm-role-tag {
            font-size: 0.95rem;
            font-weight: 600;
            color: #475569;
        }

        .cm-profile-btn {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            padding: 6px 16px 6px 8px;
            border-radius: 9999px;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
            transition: var(--transition);
        }

        .cm-profile-btn:hover {
            background: #f8fafc;
            border-color: #94a3b8;
        }

        .cm-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
            border: 1px solid #e2e8f0;
            background: #f8fafc;
        }

        .cm-name {
            font-size: 0.92rem;
            font-weight: 700;
            color: #0f172a;
        }

        .cm-arrow {
            font-size: 10px;
            color: #64748b;
        }

        /* Profile Dropdown */
        .profile-dropdown-wrapper {
            position: relative;
        }

        .cm-dropdown-menu {
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            width: 250px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 12px 28px rgba(0, 0, 0, 0.1);
            padding: 8px 0;
            z-index: 1000;
        }

        .cm-dropdown-menu.show {
            display: block;
        }

        .cm-dropdown-user {
            padding: 12px 18px;
            border-bottom: 1px solid #f1f5f9;
        }

        .cm-dropdown-user strong {
            display: block;
            font-size: 0.94rem;
            color: #0f172a;
        }

        .cm-dropdown-user span {
            font-size: 0.8rem;
            color: #64748b;
        }

        .cm-dropdown-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 18px;
            color: #334155;
            text-decoration: none;
            font-size: 0.88rem;
            font-weight: 600;
            transition: background 0.15s;
        }

        .cm-dropdown-item:hover {
            background: #f8fafc;
            color: #0284c7;
        }

        .cm-dropdown-item.logout {
            color: #dc2626;
            border-top: 1px solid #f1f5f9;
        }

        .cm-dropdown-item.logout:hover {
            background: #fef2f2;
        }

        /* Main Content Wrapper */
        .cm-container {
            max-width: 1100px;
            margin: 36px auto 70px auto;
            padding: 0 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* Course Management Title & Tabs */
        .cm-title-row {
            margin-bottom: 4px;
        }

        .cm-page-title {
            font-size: 1.85rem;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 16px 0;
            letter-spacing: -0.02em;
        }

        .cm-tabs-bar {
            display: flex;
            align-items: center;
            gap: 28px;
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 2px;
        }

        .cm-tab-link {
            font-size: 1rem;
            font-weight: 600;
            color: #64748b;
            text-decoration: none;
            padding: 6px 4px 10px 4px;
            position: relative;
            transition: color 0.2s;
        }

        .cm-tab-link:hover {
            color: #0284c7;
        }

        .cm-tab-link.active {
            color: #0284c7;
            font-weight: 700;
        }

        .cm-tab-link.active::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            right: 0;
            height: 3px;
            background: #0284c7;
            border-radius: 3px 3px 0 0;
        }

        /* Card 1: Full Course Visibility Bar */
        .cm-card-visibility {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 14px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
            flex-wrap: wrap;
            gap: 12px;
        }

        .cm-vis-left {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .cm-vis-label {
            font-size: 0.95rem;
            font-weight: 700;
            color: #0f172a;
        }

        .cm-vis-select-wrapper {
            position: relative;
            display: inline-block;
        }

        .cm-vis-select {
            appearance: none;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 6px 32px 6px 12px;
            font-size: 0.88rem;
            font-weight: 700;
            color: #1e293b;
            cursor: pointer;
            outline: none;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .cm-vis-select:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.12);
        }

        .cm-vis-chevron {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 9px;
            color: #64748b;
            pointer-events: none;
        }

        .cm-vis-eye-icon {
            color: #0f172a;
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .cm-vis-actions {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .cm-vis-link-btn {
            font-size: 0.9rem;
            font-weight: 600;
            color: #0284c7;
            text-decoration: none;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 2px 6px;
            transition: color 0.15s;
        }

        .cm-vis-link-btn:hover {
            color: #0369a1;
            text-decoration: underline;
        }

        /* Card 2: Course Overview & Progress Card */
        .cm-card-progress {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 18px 24px 22px 24px;
            display: flex;
            flex-direction: column;
            gap: 14px;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
        }

        .cm-prog-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cm-prog-title {
            font-size: 1.15rem;
            font-weight: 800;
            color: #0f172a;
        }

        .cm-status-pill {
            font-size: 0.88rem;
            font-weight: 700;
            color: #1e293b;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            padding: 3px 12px;
            border-radius: 999px;
        }

        .cm-progress-track {
            width: 100%;
            height: 32px;
            background: #f1f5f9;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
            position: relative;
        }

        .cm-progress-fill {
            height: 100%;
            background: linear-gradient(90deg, #15803d 0%, #16a34a 100%);
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 0.88rem;
            font-weight: 800;
            letter-spacing: 0.03em;
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
            transition: width 0.6s ease;
        }

        /* Module / Section Cards (General, Lectures) */
        .cm-section-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .cm-section-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 14px rgba(15, 23, 42, 0.06);
        }

        .cm-section-header {
            padding: 16px 22px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #ffffff;
            cursor: pointer;
            user-select: none;
            border-bottom: 1px solid transparent;
        }

        .cm-section-card.open .cm-section-header {
            border-bottom-color: #f1f5f9;
        }

        .cm-section-title-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .cm-chevron {
            font-size: 11px;
            color: #0f172a;
            font-weight: 900;
            transition: transform 0.2s;
        }

        .cm-section-card.open .cm-chevron {
            transform: rotate(180deg);
        }

        .cm-section-name {
            font-size: 1.15rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.01em;
        }

        .cm-section-status-badge {
            font-size: 0.76rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            padding: 2px 8px;
            border-radius: 6px;
        }

        .cm-section-status-badge.locked {
            color: #64748b;
            background: #f1f5f9;
        }

        .cm-section-status-badge.active {
            color: #16a34a;
            background: #dcfce7;
        }

        .cm-section-status-badge.upcoming {
            color: #64748b;
            background: #f1f5f9;
        }

        .cm-section-tools {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .cm-tool-btn {
            background: transparent;
            border: none;
            color: #64748b;
            font-size: 0.88rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 6px;
            border-radius: 6px;
            text-decoration: none;
            transition: color 0.15s, background 0.15s;
        }

        .cm-tool-btn:hover {
            color: #0f172a;
            background: #f8fafc;
        }

        .cm-tool-btn.delete {
            color: #64748b;
        }

        .cm-tool-btn.delete:hover {
            color: #dc2626;
            background: #fef2f2;
        }

        .cm-reorder-handle {
            display: none !important;
        }

        /* Announcements Feed & Card Styles */
        .cm-ann-count-badge {
            font-size: 0.74rem;
            font-weight: 700;
            color: #0284c7;
            background: #e0f2fe;
            padding: 2px 8px;
            border-radius: 999px;
            margin-left: 8px;
        }

        .cm-btn-post-announcement {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #0284c7;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 5px 12px;
            font-size: 0.82rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .cm-btn-post-announcement:hover {
            background: #0369a1;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(2, 132, 199, 0.25);
        }

        .cm-announcements-feed {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 14px 16px;
            margin-top: 6px;
            display: block;
        }

        .cm-ann-feed-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 10px;
            border-bottom: 1px dashed #cbd5e1;
            margin-bottom: 12px;
        }

        .cm-ann-feed-title {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.88rem;
            font-weight: 700;
            color: #0f172a;
        }

        .cm-ann-feed-title svg {
            color: #0284c7;
        }

        .cm-ann-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .cm-ann-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #0284c7;
            border-radius: 8px;
            padding: 12px 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
            transition: all 0.15s ease;
        }

        .cm-ann-card:hover {
            border-color: #cbd5e1;
            border-left-color: #0369a1;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .cm-ann-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 6px;
        }

        .cm-ann-meta {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .cm-ann-pill {
            font-size: 0.72rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            padding: 2px 8px;
            border-radius: 999px;
            background: #e2e8f0;
            color: #475569;
        }

        .cm-ann-pill.important {
            background: #fef3c7;
            color: #b45309;
        }

        .cm-ann-pill.urgent {
            background: #fee2e2;
            color: #b91c1c;
        }

        .cm-ann-pill.generalupdate, .cm-ann-pill.update {
            background: #e0f2fe;
            color: #0369a1;
        }

        .cm-ann-pill.assignmenttask, .cm-ann-pill.assignment {
            background: #f3e8ff;
            color: #7e22ce;
        }

        .cm-ann-pill.examschedule, .cm-ann-pill.exam {
            background: #dcfce7;
            color: #15803d;
        }

        .cm-ann-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: #0f172a;
        }

        .cm-ann-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .cm-ann-date {
            font-size: 0.78rem;
            color: #64748b;
        }

        .cm-ann-body {
            font-size: 0.88rem;
            color: #334155;
            line-height: 1.55;
            margin-top: 4px;
        }

        .cm-ann-empty {
            padding: 16px;
            text-align: center;
            color: #64748b;
            font-size: 0.88rem;
            background: #ffffff;
            border: 1px dashed #cbd5e1;
            border-radius: 8px;
        }

        /* Section Items Body */
        .cm-section-body {
            padding: 14px 22px 18px 22px;
            background: #fafcff;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .cm-section-card:not(.open) .cm-section-body {
            display: none;
        }

        .cm-section-card.open .cm-section-body {
            display: flex;
        }

        .cm-item-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 16px;
            transition: background 0.15s, border-color 0.15s;
        }

        .cm-item-row:hover {
            border-color: #cbd5e1;
            background: #ffffff;
        }

        .cm-item-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .cm-item-icon-box {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            color: #ffffff;
        }

        .cm-item-icon-box.red {
            background: #ef4444;
        }

        .cm-item-icon-box.blue {
            background: #0284c7;
        }

        .cm-item-icon-box.slate {
            background: #f1f5f9;
            color: #475569;
        }

        .cm-item-icon-box.green {
            background: #10b981;
        }

        .cm-item-icon-box.amber {
            background: #f59e0b;
        }

        .cm-item-name {
            font-size: 0.95rem;
            font-weight: 600;
            color: #1e293b;
        }

        .cm-item-size-badge {
            font-size: 0.72rem;
            color: #64748b;
            background: #f1f5f9;
            padding: 2px 6px;
            border-radius: 4px;
            margin-left: 6px;
        }

        .cm-btn-mark-done {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 4px 12px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #475569;
            cursor: pointer;
            transition: all 0.15s;
        }

        .cm-btn-mark-done:hover {
            background: #f8fafc;
            border-color: #94a3b8;
            color: #0f172a;
        }

        .cm-btn-mark-done.done {
            background: #dcfce7;
            color: #15803d;
            border-color: #86efac;
        }

        .cm-item-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* Lecture Upload Resource Trigger Button */
        .cm-upload-resource-row {
            padding-top: 6px;
            border-top: 1px dashed #e2e8f0;
            display: flex;
            justify-content: flex-start;
        }

        .cm-btn-upload-resource {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #eff6ff;
            color: #0284c7;
            border: 1px dashed #93c5fd;
            border-radius: 8px;
            padding: 7px 16px;
            font-size: 0.88rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }

        .cm-btn-upload-resource:hover {
            background: #0284c7;
            color: #ffffff;
            border-color: #0284c7;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.15);
        }

        /* Action Buttons Area */
        .cm-actions-footer {
            margin-top: 14px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 14px;
        }

        .btn-add-lecture-topic {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            max-width: 580px;
            background: #0284c7;
            color: #ffffff;
            border: none;
            border-radius: 8px;
            padding: 13px 28px;
            font-size: 1.05rem;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(2, 132, 199, 0.28);
            transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
        }

        .btn-add-lecture-topic:hover {
            background: #0369a1;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(2, 132, 199, 0.35);
        }

        .btn-back-dashboard {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #092853;
            color: #ffffff;
            text-decoration: none;
            border-radius: 9999px;
            padding: 10px 30px;
            font-size: 0.96rem;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(9, 40, 83, 0.22);
            transition: background 0.2s, transform 0.15s;
        }

        .btn-back-dashboard:hover {
            background: #061e40;
            transform: translateY(-2px);
        }

        /* Modal Styles */
        .cm-modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(4px);
            z-index: 10000;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .cm-modal-overlay.open {
            display: flex;
        }

        .cm-modal-card {
            background: #ffffff;
            border-radius: 16px;
            width: 100%;
            max-width: 600px;
            box-shadow: 0 20px 45px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            animation: modalPop 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes modalPop {
            from { transform: scale(0.95); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .cm-modal-header {
            padding: 20px 26px;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .cm-modal-header h3 {
            margin: 0;
            font-size: 1.25rem;
            font-weight: 800;
            color: #0f172a;
        }

        .cm-modal-close {
            background: transparent;
            border: none;
            font-size: 1.4rem;
            color: #64748b;
            cursor: pointer;
            line-height: 1;
        }

        .cm-modal-body {
            padding: 24px 26px;
            max-height: 75vh;
            overflow-y: auto;
        }

        .cm-form-group {
            margin-bottom: 18px;
        }

        .cm-form-group label {
            display: block;
            font-size: 0.88rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 6px;
        }

        .cm-form-input, .cm-form-select, .cm-form-textarea {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.92rem;
            color: #0f172a;
            outline: none;
            box-sizing: border-box;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        .cm-form-input:focus, .cm-form-select:focus, .cm-form-textarea:focus {
            border-color: #0284c7;
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.12);
        }

        /* Drag & Drop Upload Zone */
        .cm-file-dropzone {
            border: 2px dashed #93c5fd;
            background: #f8fafc;
            border-radius: 12px;
            padding: 26px 18px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }

        .cm-file-dropzone:hover, .cm-file-dropzone.dragover {
            background: #eff6ff;
            border-color: #0284c7;
        }

        .cm-dropzone-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .cm-dropzone-icon {
            color: #0284c7;
            margin-bottom: 8px;
        }

        .cm-dropzone-text {
            font-size: 0.94rem;
            font-weight: 700;
            color: #1e293b;
        }

        .cm-dropzone-sub {
            font-size: 0.78rem;
            color: #64748b;
            margin-top: 4px;
        }

        .cm-selected-file-preview {
            display: none;
            margin-top: 12px;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 8px 14px;
            align-items: center;
            justify-content: space-between;
            font-size: 0.88rem;
            font-weight: 600;
            color: #0f172a;
        }

        .cm-modal-footer {
            padding: 16px 26px;
            border-top: 1px solid #e2e8f0;
            background: #f8fafc;
            display: flex;
            justify-content: flex-end;
            gap: 12px;
        }

        .cm-btn-secondary {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #475569;
            padding: 9px 18px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
        }

        .cm-btn-primary {
            background: #0284c7;
            border: none;
            color: #ffffff;
            padding: 9px 22px;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .cm-btn-primary:hover {
            background: #0369a1;
        }

        .cm-btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

    <!-- Top Full-Width Header Matching Mockup -->
    <header class="cm-top-header">
        <a href="index.php?action=provider_dashboard" class="cm-brand">
            <img src="public/images/logo.png" alt="CareerConnect" class="cm-brand-logo" onerror="this.style.display='none'">
            <div class="cm-brand-text">Career<span>Connect</span></div>
        </a>

        <div class="cm-header-right">
            <span class="cm-role-tag">Training Provider</span>

            <div class="profile-dropdown-wrapper">
                <button type="button" class="cm-profile-btn" id="profileButton">
                    <img src="public/images/user.png" alt="User" class="cm-avatar" onerror="this.src='data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' width=\'32\' height=\'32\' viewBox=\'0 0 24 24\' fill=\'none\' stroke=\'%2364748b\' stroke-width=\'2\'><path d=\'M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2\'></path><circle cx=\'12\' cy=\'7\' r=\'4\'></circle></svg>'">
                    <span class="cm-name"><?php echo htmlspecialchars($provider['provider_name'] ?? 'ABC Institute'); ?></span>
                    <span class="cm-arrow">▼</span>
                </button>

                <div class="cm-dropdown-menu" id="profileDropdown">
                    <div class="cm-dropdown-user">
                        <strong><?php echo htmlspecialchars($provider['provider_name'] ?? 'ABC Institute'); ?></strong>
                        <span><?php echo htmlspecialchars($provider['contact_email'] ?? $provider['email'] ?? 'trainer@careerconnect.com'); ?></span>
                    </div>
                    <a href="index.php?action=provider_dashboard" class="cm-dropdown-item">Dashboard</a>
                    <a href="index.php?action=provider_dashboard&view=courses" class="cm-dropdown-item">My Courses</a>
                    <a href="index.php?action=provider_profile" class="cm-dropdown-item">Settings</a>
                    <a href="index.php?action=logout" class="cm-dropdown-item logout">Logout</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Course Management Container -->
    <main class="cm-container">
        <!-- Title & Tabs Row -->
        <div class="cm-title-row">
            <h1 class="cm-page-title">Course Management: <?php echo htmlspecialchars($course['title'] ?? 'EN2201 Entrepreneurship'); ?></h1>
            <div class="cm-tabs-bar">
                <a href="#" class="cm-tab-link active">Course</a>
            </div>
        </div>

        <!-- Card 1: Full Course Visibility Control -->
        <div class="cm-card-visibility">
            <div class="cm-vis-left">
                <span class="cm-vis-label">Full Course Visibility:</span>
                <div class="cm-vis-select-wrapper">
                    <select class="cm-vis-select" id="courseVisibilitySelect" onchange="updateVisibilityToast()">
                        <option value="visible" <?php echo (($curriculum['visibility'] ?? 'visible') === 'visible') ? 'selected' : ''; ?>>FULL COURSE: Visible (Enabled)</option>
                        <option value="hidden" <?php echo (($curriculum['visibility'] ?? '') === 'hidden') ? 'selected' : ''; ?>>FULL COURSE: Hidden (Draft)</option>
                        <option value="archived" <?php echo (($curriculum['visibility'] ?? '') === 'archived') ? 'selected' : ''; ?>>FULL COURSE: Archived</option>
                    </select>
                    <span class="cm-vis-chevron">▼</span>
                </div>
                <span class="cm-vis-eye-icon" title="Visibility state active">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </span>
            </div>

            <div class="cm-vis-actions">
                <button type="button" class="cm-vis-link-btn" onclick="openSettingsModal()">[Edit Course Settings]</button>
                <a href="index.php?action=provider_dashboard&view=analytics<?php echo !empty($course['course_id']) ? '&course_id='.$course['course_id'] : ''; ?>" class="cm-vis-link-btn">[View Analytics]</a>
            </div>
        </div>

        <!-- Card 2: Course Overview & Progress -->
        <div class="cm-card-progress">
            <div class="cm-prog-header-row">
                <span class="cm-prog-title">Course Overview & Progress</span>
                <span class="cm-status-pill">Status: <strong><?php echo htmlspecialchars($curriculum['status'] ?? 'In-Progress'); ?></strong></span>
            </div>

            <div class="cm-progress-track">
                <div class="cm-progress-fill" style="width: <?php echo (int)($curriculum['progress_percent'] ?? 65); ?>%;">
                    PROGRESS BAR: <?php echo (int)($curriculum['progress_percent'] ?? 65); ?>% Completed
                </div>
            </div>
        </div>

        <!-- Section 1: General (Announcements, Feedback Form, etc.) -->
        <?php 
            $general = $curriculum['general'] ?? ['id' => 'sec-general', 'title' => 'General', 'is_open' => true, 'items' => []]; 
            $announcementsList = $curriculum['announcements'] ?? [];
        ?>
        <div class="cm-section-card <?php echo !empty($general['is_open']) ? 'open' : ''; ?>" id="sec-general">
            <div class="cm-section-header" onclick="toggleSection('sec-general')">
                <div class="cm-section-title-wrap">
                    <span class="cm-chevron"><?php echo !empty($general['is_open']) ? '▲' : '▼'; ?></span>
                    <span class="cm-section-name"><?php echo htmlspecialchars($general['title'] ?? 'General'); ?></span>
                </div>
                <div class="cm-section-tools" onclick="event.stopPropagation()">
                    <button type="button" class="cm-tool-btn" title="Edit General Section Name" onclick="renameSection('sec-general', '<?php echo htmlspecialchars(addslashes($general['title'] ?? 'General')); ?>')">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    </button>
                    <button type="button" class="cm-tool-btn" title="Toggle Section Visibility" onclick="toggleVisibility(this)">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                    </button>
                </div>
            </div>

            <div class="cm-section-body">
                <!-- Announcements Interactive Block -->
                <div class="cm-item-row" id="item-announcements-row" data-item-id="item-announcements">
                    <div class="cm-item-left">
                        <div class="cm-item-icon-box red">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                        </div>
                        <div>
                            <span class="cm-item-name">Course Announcements</span>
                            <span class="cm-ann-count-badge" id="announcementBadgeCount"><?php echo count($announcementsList); ?> active</span>
                        </div>
                    </div>
                    <div class="cm-item-right">
                        <button type="button" class="cm-btn-post-announcement" onclick="openPostAnnouncementModal()">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <span>Post Announcement</span>
                        </button>
                        <button type="button" class="cm-tool-btn" onclick="toggleAnnouncementsFeed()" id="toggleAnnFeedBtn">
                            <span id="annToggleText">View Notices</span> <span id="annToggleArrow">▼</span>
                        </button>
                        <button type="button" class="cm-tool-btn" title="Edit Name" onclick="editItemPrompt(this, 'Course Announcements')">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </button>
                        <button type="button" class="cm-tool-btn" title="Toggle Visibility" onclick="toggleItemVisibility(this)">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                        </button>
                    </div>
                </div>

                <!-- Live Announcements Feed -->
                <div class="cm-announcements-feed" id="announcementsFeed">
                    <div class="cm-ann-feed-header">
                        <div class="cm-ann-feed-title">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 17H2a3 3 0 0 0 3-3V9a7 7 0 0 1 14 0v5a3 3 0 0 0 3 3zm-8.27 4a2 2 0 0 1-3.46 0"></path></svg>
                            <span>Live Notices for Enrolled Students</span>
                        </div>
                        <button type="button" class="cm-tool-btn" onclick="openPostAnnouncementModal()">+ New Announcement</button>
                    </div>

                    <div class="cm-ann-list" id="announcementsListContainer">
                        <?php if (!empty($announcementsList)): ?>
                            <?php foreach ($announcementsList as $ann): ?>
                                <div class="cm-ann-card" id="<?php echo htmlspecialchars($ann['id'] ?? uniqid()); ?>">
                                    <div class="cm-ann-top">
                                        <div class="cm-ann-meta">
                                            <span class="cm-ann-pill <?php echo strtolower(preg_replace('/[^a-zA-Z]/', '', $ann['tag'] ?? 'important')); ?>"><?php echo htmlspecialchars($ann['tag'] ?? 'Update'); ?></span>
                                            <span class="cm-ann-title"><?php echo htmlspecialchars($ann['title'] ?? ''); ?></span>
                                        </div>
                                        <div class="cm-ann-actions">
                                            <span class="cm-ann-date"><?php echo htmlspecialchars($ann['date'] ?? date('M d, Y')); ?></span>
                                            <button type="button" class="cm-tool-btn delete" onclick="deleteAnnouncement('<?php echo htmlspecialchars($ann['id'] ?? ''); ?>', this)" title="Delete Announcement">[Delete]</button>
                                        </div>
                                    </div>
                                    <?php if (!empty($ann['content'])): ?>
                                        <div class="cm-ann-body"><?php echo nl2br(htmlspecialchars($ann['content'])); ?></div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="cm-ann-empty" id="emptyAnnouncementsMsg">
                                <span>No announcements posted yet. Click <strong>"+ Post Announcement"</strong> to share an update with learners.</span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Other General Items (Feedback form, uploads, etc.) -->
                <div class="cm-items-container" id="items-sec-general">
                    <?php if (!empty($general['items'])): ?>
                        <?php foreach ($general['items'] as $item): ?>
                            <?php if (($item['type'] ?? '') === 'announcement') continue; ?>
                            <div class="cm-item-row" id="<?php echo htmlspecialchars($item['id'] ?? uniqid()); ?>" data-item-id="<?php echo htmlspecialchars($item['id'] ?? ''); ?>">
                                <div class="cm-item-left">
                                    <div class="cm-item-icon-box <?php echo htmlspecialchars($item['icon'] ?? 'blue'); ?>">
                                        <?php if (($item['type'] ?? '') === 'form'): ?>
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                                        <?php else: ?>
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                        <?php endif; ?>
                                    </div>
                                    <div>
                                        <span class="cm-item-name"><?php echo htmlspecialchars($item['title'] ?? ''); ?></span>
                                        <?php if (!empty($item['file_size'])): ?>
                                            <span class="cm-item-size-badge"><?php echo htmlspecialchars($item['file_size']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="cm-item-right">
                                    <?php if (!empty($item['has_mark_done'])): ?>
                                        <button type="button" class="cm-btn-mark-done <?php echo !empty($item['is_done']) ? 'done' : ''; ?>" onclick="toggleDone(this)"><?php echo !empty($item['is_done']) ? '✓ Done' : 'Mark as done'; ?></button>
                                    <?php endif; ?>

                                    <?php if (!empty($item['file_path'])): ?>
                                        <a href="<?php echo htmlspecialchars($item['file_path']); ?>" target="_blank" download class="cm-tool-btn" title="Download / View File">👁</a>
                                    <?php endif; ?>

                                    <button type="button" class="cm-tool-btn" title="Edit Name" onclick="editItemPrompt(this, '<?php echo htmlspecialchars(addslashes($item['title'] ?? '')); ?>')">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </button>
                                    <button type="button" class="cm-tool-btn" title="Toggle Visibility" onclick="toggleItemVisibility(this)">
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                                    </button>
                                    <button type="button" class="cm-tool-btn delete" onclick="deleteCurriculumItem('<?php echo htmlspecialchars($item['id'] ?? ''); ?>', this)">[Delete]</button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <!-- Upload Resource to General -->
                <div class="cm-upload-resource-row">
                    <button type="button" class="cm-btn-upload-resource" onclick="openUploadModal('sec-general', 'General')">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        <span>+ Upload File / Resource</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Section 2+: Lectures Loop (Lecture 01, Lecture 02, Lecture 03...) -->
        <div id="lecturesListContainer" style="display: flex; flex-direction: column; gap: 16px;">
            <?php if (!empty($curriculum['lectures'])): ?>
                <?php foreach ($curriculum['lectures'] as $lecIndex => $lec): ?>
                    <?php 
                        $lecId = htmlspecialchars($lec['id'] ?? 'sec-lec-' . $lecIndex);
                        $lecStatus = strtoupper($lec['status'] ?? 'UPCOMING');
                        $statusClass = strtolower($lecStatus);
                        $isOpen = !empty($lec['is_open']);
                    ?>
                    <div class="cm-section-card <?php echo $isOpen ? 'open' : ''; ?>" id="<?php echo $lecId; ?>">
                        <div class="cm-section-header" onclick="toggleSection('<?php echo $lecId; ?>')">
                            <div class="cm-section-title-wrap">
                                <span class="cm-chevron"><?php echo $isOpen ? '▲' : '▼'; ?></span>
                                <span class="cm-section-name"><?php echo htmlspecialchars($lec['title'] ?? 'Lecture'); ?></span>
                                <span class="cm-section-status-badge <?php echo $statusClass; ?>"><?php echo $lecStatus; ?></span>
                            </div>
                            <div class="cm-section-tools" onclick="event.stopPropagation()">
                                <button type="button" class="cm-tool-btn" title="Edit Lecture Title" onclick="editLectureTitle('<?php echo $lecId; ?>', '<?php echo htmlspecialchars(addslashes($lec['title'] ?? '')); ?>')">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </button>
                                <button type="button" class="cm-tool-btn" title="Toggle Lock/Active" onclick="toggleLectureLock(this)">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                                </button>
                            </div>
                        </div>

                        <div class="cm-section-body">
                            <!-- Items List inside this lecture -->
                            <div class="cm-items-container" id="items-<?php echo $lecId; ?>">
                                <?php if (!empty($lec['items'])): ?>
                                    <?php foreach ($lec['items'] as $item): ?>
                                        <div class="cm-item-row" id="<?php echo htmlspecialchars($item['id'] ?? uniqid()); ?>" data-item-id="<?php echo htmlspecialchars($item['id'] ?? ''); ?>">
                                            <div class="cm-item-left">
                                                <div class="cm-item-icon-box slate">
                                                    <?php if (($item['type'] ?? '') === 'video'): ?>
                                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg>
                                                    <?php elseif (($item['type'] ?? '') === 'assignment'): ?>
                                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"></path><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
                                                    <?php else: ?>
                                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                                    <?php endif; ?>
                                                </div>
                                                <div>
                                                    <span class="cm-item-name"><?php echo htmlspecialchars($item['title'] ?? ''); ?></span>
                                                    <?php if (!empty($item['file_size'])): ?>
                                                        <span class="cm-item-size-badge"><?php echo htmlspecialchars($item['file_size']); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="cm-item-right">
                                                <?php if (!empty($item['file_path'])): ?>
                                                    <a href="<?php echo htmlspecialchars($item['file_path']); ?>" target="_blank" download class="cm-tool-btn" title="Download / Preview File">👁</a>
                                                <?php else: ?>
                                                    <button type="button" class="cm-tool-btn" title="Preview Content">👁</button>
                                                <?php endif; ?>

                                                <button type="button" class="cm-tool-btn" onclick="editItemPrompt(this, '<?php echo htmlspecialchars(addslashes($item['title'] ?? '')); ?>')">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                                </button>
                                                <button type="button" class="cm-tool-btn" onclick="toggleItemVisibility(this)">
                                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                                                </button>
                                                <button type="button" class="cm-tool-btn delete" onclick="deleteCurriculumItem('<?php echo htmlspecialchars($item['id'] ?? ''); ?>', this)">[Delete]</button>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <!-- Upload Resource Button inside this Lecture -->
                            <div class="cm-upload-resource-row">
                                <button type="button" class="cm-btn-upload-resource" onclick="openUploadModal('<?php echo $lecId; ?>', '<?php echo htmlspecialchars(addslashes($lec['title'] ?? 'Lecture')); ?>')">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                                    <span>+ Upload File / Resource to <?php echo htmlspecialchars($lec['title'] ?? 'Lecture'); ?></span>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Bottom Actions Row Matching Mockup -->
        <div class="cm-actions-footer">
            <button type="button" class="btn-add-lecture-topic" onclick="openAddLectureModal()">
                <span>+ Add New Lecture / Topic</span>
            </button>

            <a href="index.php?action=provider_dashboard&view=courses" class="btn-back-dashboard">
                <span>&lt;== Back to All Courses Dashboard</span>
            </a>
        </div>
    </main>

    <!-- Modal 1: Upload File / Resource to Lecture -->
    <div class="cm-modal-overlay" id="uploadFileModal">
        <div class="cm-modal-card">
            <div class="cm-modal-header">
                <h3 id="uploadModalTitle">Upload Resource to Lecture</h3>
                <button type="button" class="cm-modal-close" onclick="closeUploadModal()">&times;</button>
            </div>
            <form id="lectureUploadForm" onsubmit="submitLectureUpload(event)" enctype="multipart/form-data">
                <input type="hidden" name="action_type" value="upload_lecture_file">
                <input type="hidden" name="is_ajax" value="1">
                <input type="hidden" name="course_id" id="uploadCourseId" value="<?php echo (int)($course['course_id'] ?? 1); ?>">
                <input type="hidden" name="lecture_id" id="uploadLectureId" value="">

                <div class="cm-modal-body">
                    <!-- Drag & Drop Area -->
                    <div class="cm-form-group">
                        <label>Select or Drop File <span style="color: #ef4444;">*</span></label>
                        <div class="cm-file-dropzone" id="fileDropzone">
                            <input type="file" name="lecture_file" id="lectureFileInput" class="cm-dropzone-input" onchange="handleFileSelected(event)" required>
                            <div class="cm-dropzone-icon">
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                            </div>
                            <div class="cm-dropzone-text">Click to browse or drag and drop files here</div>
                            <div class="cm-dropzone-sub">Supported formats: PDF, DOCX, PPTX, MP4, Videos, ZIP, Slides (Max 50MB)</div>
                        </div>

                        <div class="cm-selected-file-preview" id="filePreviewBox">
                            <span id="previewFileName">filename.pdf</span>
                            <span id="previewFileSize" style="color: #64748b; font-size: 0.8rem;">2.4 MB</span>
                        </div>
                    </div>

                    <!-- Content Type -->
                    <div class="cm-form-group">
                        <label>Content / Resource Type</label>
                        <select name="item_type" id="uploadItemType" class="cm-form-select">
                            <option value="[Sub-Content]">[Sub-Content] (Video / Multimedia Tutorial)</option>
                            <option value="[Assignment]">[Assignment] (Task / Project Document)</option>
                            <option value="[Reading Material]">[Reading Material] (Lecture Slides / PDF Notes)</option>
                            <option value="[Lecture Notes]">[Lecture Notes] (Handouts & Summaries)</option>
                        </select>
                    </div>

                    <!-- Custom Title / Label -->
                    <div class="cm-form-group">
                        <label>Resource Title (Optional)</label>
                        <input type="text" name="item_title" id="uploadItemTitle" class="cm-form-input" placeholder="e.g. Business Model Canvas Video">
                        <span style="font-size: 0.78rem; color: #64748b;">If left blank, file name will be used automatically.</span>
                    </div>

                    <!-- Upload Progress Bar (during upload) -->
                    <div id="uploadProgressBarBox" style="display: none; margin-top: 14px;">
                        <div style="font-size: 0.82rem; font-weight: 700; color: #0284c7; margin-bottom: 4px;" id="uploadStatusText">Uploading file...</div>
                        <div style="width: 100%; height: 8px; background: #e2e8f0; border-radius: 99px; overflow: hidden;">
                            <div id="uploadProgressBar" style="width: 0%; height: 100%; background: #0284c7; transition: width 0.3s;"></div>
                        </div>
                    </div>
                </div>

                <div class="cm-modal-footer">
                    <button type="button" class="cm-btn-secondary" onclick="closeUploadModal()">Cancel</button>
                    <button type="submit" class="cm-btn-primary" id="btnSubmitUpload">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                        <span>Upload File</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 2: Edit Course Settings -->
    <div class="cm-modal-overlay" id="settingsModal">
        <div class="cm-modal-card">
            <div class="cm-modal-header">
                <h3>Edit Course Settings</h3>
                <button type="button" class="cm-modal-close" onclick="closeSettingsModal()">&times;</button>
            </div>
            <form action="index.php?action=manage_course<?php echo !empty($course['course_id']) ? '&id='.$course['course_id'] : ''; ?>" method="POST">
                <div class="cm-modal-body">
                    <?php if (!empty($course['course_id'])): ?>
                        <input type="hidden" name="course_id" value="<?php echo $course['course_id']; ?>">
                    <?php endif; ?>

                    <div class="cm-form-group">
                        <label>Course Title <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="title" class="cm-form-input" value="<?php echo htmlspecialchars($course['title'] ?? ''); ?>" required>
                    </div>

                    <div class="cm-form-group">
                        <label>Category <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="category" class="cm-form-input" value="<?php echo htmlspecialchars($course['category'] ?? ''); ?>" required>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 14px;">
                        <div class="cm-form-group">
                            <label>Duration</label>
                            <input type="text" name="duration" class="cm-form-input" value="<?php echo htmlspecialchars($course['duration'] ?? ''); ?>">
                        </div>
                        <div class="cm-form-group">
                            <label>Course Fee (LKR)</label>
                            <input type="number" step="0.01" name="fee" class="cm-form-input" value="<?php echo htmlspecialchars($course['fee'] ?? '0.00'); ?>">
                        </div>
                    </div>

                    <div class="cm-form-group">
                        <label>Course Description</label>
                        <textarea name="description" class="cm-form-textarea" rows="4"><?php echo htmlspecialchars($course['description'] ?? ''); ?></textarea>
                    </div>
                </div>
                <div class="cm-modal-footer">
                    <button type="button" class="cm-btn-secondary" onclick="closeSettingsModal()">Cancel</button>
                    <button type="submit" class="cm-btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal 3: Add New Lecture / Topic -->
    <div class="cm-modal-overlay" id="addLectureModal">
        <div class="cm-modal-card">
            <div class="cm-modal-header">
                <h3>Add New Lecture / Topic</h3>
                <button type="button" class="cm-modal-close" onclick="closeAddLectureModal()">&times;</button>
            </div>
            <div class="cm-modal-body">
                <div class="cm-form-group">
                    <label>Lecture / Module Title <span style="color: #ef4444;">*</span></label>
                    <input type="text" id="newLectureTitle" class="cm-form-input" placeholder="e.g. Lecture 04 - Financial Projections & Pitching" required>
                </div>

                <div class="cm-form-group">
                    <label>Initial Status</label>
                    <select id="newLectureStatus" class="cm-form-select">
                        <option value="UPCOMING">Upcoming</option>
                        <option value="ACTIVE">Active</option>
                        <option value="LOCKED">Locked</option>
                    </select>
                </div>
            </div>
            <div class="cm-modal-footer">
                <button type="button" class="cm-btn-secondary" onclick="closeAddLectureModal()">Cancel</button>
                <button type="button" class="cm-btn-primary" onclick="confirmAddLecture()">Add Topic</button>
            </div>
        </div>
    </div>

    <!-- Modal 4: Post Course Announcement -->
    <div class="cm-modal-overlay" id="postAnnouncementModal">
        <div class="cm-modal-card">
            <div class="cm-modal-header">
                <h3>📢 Post Course Announcement</h3>
                <button type="button" class="cm-modal-close" onclick="closePostAnnouncementModal()">&times;</button>
            </div>
            <form id="postAnnouncementForm" onsubmit="submitPostAnnouncement(event)">
                <input type="hidden" name="action_type" value="add_announcement">
                <input type="hidden" name="is_ajax" value="1">
                <input type="hidden" name="course_id" value="<?php echo (int)($course['course_id'] ?? 1); ?>">

                <div class="cm-modal-body">
                    <div class="cm-form-group">
                        <label>Announcement Title <span style="color: #ef4444;">*</span></label>
                        <input type="text" name="announcement_title" id="announcementTitleInput" class="cm-form-input" placeholder="e.g. Assignment 1 Submission Deadline Extended" required>
                    </div>

                    <div class="cm-form-group">
                        <label>Category / Priority Tag</label>
                        <select name="announcement_tag" id="announcementTagInput" class="cm-form-select">
                            <option value="Important">Important</option>
                            <option value="General Update">General Update</option>
                            <option value="Urgent">Urgent</option>
                            <option value="Assignment / Task">Assignment / Task</option>
                            <option value="Exam & Schedule">Exam & Schedule</option>
                        </select>
                    </div>

                    <div class="cm-form-group">
                        <label>Announcement Details / Message <span style="color: #ef4444;">*</span></label>
                        <textarea name="announcement_content" id="announcementContentInput" class="cm-form-textarea" rows="4" placeholder="Write your announcement details for students enrolled in this course..." required></textarea>
                    </div>

                    <div style="display: flex; align-items: center; gap: 8px; margin-top: 10px;">
                        <input type="checkbox" id="notifyLearners" checked style="accent-color: #0284c7; width: 16px; height: 16px;">
                        <label for="notifyLearners" style="margin: 0; font-size: 0.88rem; color: #475569; cursor: pointer;">Send email & portal notification to all enrolled learners</label>
                    </div>
                </div>

                <div class="cm-modal-footer">
                    <button type="button" class="cm-btn-secondary" onclick="closePostAnnouncementModal()">Cancel</button>
                    <button type="submit" class="cm-btn-primary" id="btnSubmitAnnouncement">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
                        <span>Publish Announcement</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Profile dropdown
        const profileBtn = document.getElementById('profileButton');
        const profileDropdown = document.getElementById('profileDropdown');

        if (profileBtn && profileDropdown) {
            profileBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                profileDropdown.classList.toggle('show');
            });

            document.addEventListener('click', function(e) {
                if (!profileDropdown.contains(e.target)) {
                    profileDropdown.classList.remove('show');
                }
            });
        }

        // Section collapse toggler
        function toggleSection(secId) {
            const sec = document.getElementById(secId);
            if (sec) {
                sec.classList.toggle('open');
                const chevron = sec.querySelector('.cm-chevron');
                if (chevron) {
                    chevron.textContent = sec.classList.contains('open') ? '▲' : '▼';
                }
            }
        }

        // Mark as done toggle
        function toggleDone(btn) {
            btn.classList.toggle('done');
            btn.textContent = btn.classList.contains('done') ? '✓ Done' : 'Mark as done';
        }

        // Visibility toast
        function updateVisibilityToast() {
            const sel = document.getElementById('courseVisibilitySelect');
            alert('Course visibility set to: ' + sel.options[sel.selectedIndex].text);
        }

        // Open Upload Modal
        function openUploadModal(lectureId, lectureTitle) {
            document.getElementById('uploadLectureId').value = lectureId;
            document.getElementById('uploadModalTitle').textContent = 'Upload Resource to ' + lectureTitle;
            document.getElementById('lectureFileInput').value = '';
            document.getElementById('uploadItemTitle').value = '';
            document.getElementById('filePreviewBox').style.display = 'none';
            document.getElementById('uploadProgressBarBox').style.display = 'none';
            document.getElementById('btnSubmitUpload').disabled = false;
            document.getElementById('uploadFileModal').classList.add('open');
        }

        function closeUploadModal() {
            document.getElementById('uploadFileModal').classList.remove('open');
        }

        // Handle File Selection Preview
        function handleFileSelected(event) {
            const file = event.target.files[0];
            if (file) {
                const previewBox = document.getElementById('filePreviewBox');
                document.getElementById('previewFileName').textContent = file.name;
                const sizeMb = (file.size / (1024 * 1024)).toFixed(2);
                document.getElementById('previewFileSize').textContent = sizeMb + ' MB';
                previewBox.style.display = 'flex';

                // Auto-fill title if empty
                const titleInput = document.getElementById('uploadItemTitle');
                if (!titleInput.value) {
                    const cleanName = file.name.replace(/\.[^/.]+$/, "");
                    titleInput.value = cleanName;
                }
            }
        }

        // Submit File Upload via AJAX
        function submitLectureUpload(event) {
            event.preventDefault();
            const form = document.getElementById('lectureUploadForm');
            const fileInput = document.getElementById('lectureFileInput');
            const lectureId = document.getElementById('uploadLectureId').value;

            if (!fileInput.files.length) {
                alert('Please select a file to upload.');
                return;
            }

            const btn = document.getElementById('btnSubmitUpload');
            btn.disabled = true;

            const progressBox = document.getElementById('uploadProgressBarBox');
            const progressBar = document.getElementById('uploadProgressBar');
            const statusText = document.getElementById('uploadStatusText');
            progressBox.style.display = 'block';
            progressBar.style.width = '30%';
            statusText.textContent = 'Uploading to server...';

            const formData = new FormData(form);

            fetch('index.php?action=manage_course', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                progressBar.style.width = '100%';
                if (data.success && data.item) {
                    statusText.textContent = 'Upload successful!';
                    setTimeout(() => {
                        appendUploadedItemToDOM(lectureId, data.item);
                        closeUploadModal();
                    }, 400);
                } else {
                    alert('Upload failed: ' + (data.error || 'Unknown error'));
                    btn.disabled = false;
                }
            })
            .catch(err => {
                console.error(err);
                // Fallback to regular form submission if AJAX returns HTML or fails
                form.submit();
            });
        }

        // Dynamically append newly uploaded item into the lecture container in DOM
        function appendUploadedItemToDOM(lectureId, item) {
            let container = document.getElementById('items-' + lectureId);
            if (!container) {
                const sec = document.getElementById(lectureId);
                if (sec) {
                    container = sec.querySelector('.cm-items-container') || sec.querySelector('.cm-section-body');
                }
            }

            if (!container) return;

            const secCard = document.getElementById(lectureId);
            if (secCard && !secCard.classList.contains('open')) {
                secCard.classList.add('open');
                const chevron = secCard.querySelector('.cm-chevron');
                if (chevron) chevron.textContent = '▲';
            }

            let iconSvg = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>';
            if (item.type === 'video') {
                iconSvg = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg>';
            } else if (item.type === 'assignment') {
                iconSvg = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"></path><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>';
            }

            const itemRow = document.createElement('div');
            itemRow.className = 'cm-item-row';
            itemRow.id = item.id;
            itemRow.setAttribute('data-item-id', item.id);
            itemRow.innerHTML = `
                <div class="cm-item-left">
                    <div class="cm-item-icon-box slate">${iconSvg}</div>
                    <div>
                        <span class="cm-item-name">${escapeHtml(item.title)}</span>
                        ${item.file_size ? `<span class="cm-item-size-badge">${escapeHtml(item.file_size)}</span>` : ''}
                    </div>
                </div>
                <div class="cm-item-right">
                    ${item.file_path ? `<a href="${escapeHtml(item.file_path)}" target="_blank" download class="cm-tool-btn" title="Download / Preview File">👁</a>` : '<button type="button" class="cm-tool-btn">👁</button>'}
                    <button type="button" class="cm-tool-btn" onclick="editItemPrompt(this, '${escapeHtml(item.title)}')">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    </button>
                    <button type="button" class="cm-tool-btn" onclick="toggleItemVisibility(this)">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                    </button>
                    <button type="button" class="cm-tool-btn delete" onclick="deleteCurriculumItem('${item.id}', this)">[Delete]</button>
                </div>
            `;
            container.appendChild(itemRow);
        }

        // Delete curriculum item (Permanently remove assignment, video, or lecture item)
        function deleteCurriculumItem(itemId, btn) {
            if (!confirm('Are you sure you want to delete this resource?')) return;
            const row = btn.closest('.cm-item-row');
            const courseId = document.getElementById('uploadCourseId') ? document.getElementById('uploadCourseId').value : '<?php echo (int)($course['course_id'] ?? 1); ?>';
            const titleEl = row ? row.querySelector('.cm-item-name') : null;
            const itemTitle = titleEl ? titleEl.textContent.trim() : '';
            const actualItemId = itemId || (row ? (row.getAttribute('data-item-id') || row.id) : '');

            const formData = new FormData();
            formData.append('action_type', 'delete_lecture_item');
            formData.append('item_id', actualItemId);
            formData.append('item_title', itemTitle);
            formData.append('course_id', courseId);
            formData.append('is_ajax', '1');

            fetch('index.php?action=manage_course&id=' + courseId, {
                method: 'POST',
                body: formData
            }).then(res => res.json().catch(() => ({ success: true })))
            .then(() => {
                if (row) {
                    row.style.transition = 'all 0.25s ease';
                    row.style.opacity = '0';
                    row.style.transform = 'translateX(20px)';
                    setTimeout(() => row.remove(), 250);
                }
            }).catch(() => {
                if (row) row.remove();
            });
        }

        // Announcement Functions
        function openPostAnnouncementModal() {
            document.getElementById('announcementTitleInput').value = '';
            document.getElementById('announcementContentInput').value = '';
            document.getElementById('postAnnouncementModal').classList.add('open');
            document.getElementById('announcementTitleInput').focus();
        }

        function closePostAnnouncementModal() {
            document.getElementById('postAnnouncementModal').classList.remove('open');
        }

        function toggleAnnouncementsFeed() {
            const feed = document.getElementById('announcementsFeed');
            if (!feed) return;
            const isVisible = feed.style.display !== 'none';
            feed.style.display = isVisible ? 'none' : 'block';
            const arrow = document.getElementById('annToggleArrow');
            if (arrow) arrow.textContent = isVisible ? '▼' : '▲';
        }

        function submitPostAnnouncement(event) {
            event.preventDefault();
            const form = document.getElementById('postAnnouncementForm');
            const courseId = document.getElementById('uploadCourseId') ? document.getElementById('uploadCourseId').value : '<?php echo (int)($course['course_id'] ?? 1); ?>';
            const formData = new FormData(form);
            formData.set('course_id', courseId);

            const btn = document.getElementById('btnSubmitAnnouncement');
            btn.disabled = true;

            fetch('index.php?action=manage_course&id=' + courseId, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                btn.disabled = false;
                if (data.success && data.announcement) {
                    appendAnnouncementToDOM(data.announcement);
                    closePostAnnouncementModal();
                } else {
                    alert('Could not post announcement. Please try again.');
                }
            })
            .catch(err => {
                console.error(err);
                btn.disabled = false;
                form.submit();
            });
        }

        function appendAnnouncementToDOM(ann) {
            const container = document.getElementById('announcementsListContainer');
            const emptyMsg = document.getElementById('emptyAnnouncementsMsg');
            if (emptyMsg) emptyMsg.style.display = 'none';

            const feed = document.getElementById('announcementsFeed');
            if (feed) feed.style.display = 'block';
            const arrow = document.getElementById('annToggleArrow');
            if (arrow) arrow.textContent = '▲';

            const card = document.createElement('div');
            card.className = 'cm-ann-card';
            card.id = ann.id;
            const tagClass = (ann.tag || '').toLowerCase().replace(/[^a-z]/g, '');

            card.innerHTML = `
                <div class="cm-ann-top">
                    <div class="cm-ann-meta">
                        <span class="cm-ann-pill ${tagClass}">${escapeHtml(ann.tag || 'Update')}</span>
                        <span class="cm-ann-title">${escapeHtml(ann.title)}</span>
                    </div>
                    <div class="cm-ann-actions">
                        <span class="cm-ann-date">${escapeHtml(ann.date || 'Just now')}</span>
                        <button type="button" class="cm-tool-btn delete" onclick="deleteAnnouncement('${escapeHtml(ann.id)}', this)" title="Delete Announcement">[Delete]</button>
                    </div>
                </div>
                ${ann.content ? `<div class="cm-ann-body">${escapeHtml(ann.content).replace(/\n/g, '<br>')}</div>` : ''}
            `;

            if (container.firstChild) {
                container.insertBefore(card, container.firstChild);
            } else {
                container.appendChild(card);
            }

            updateAnnouncementCount();
        }

        function deleteAnnouncement(annId, btn) {
            if (!confirm('Are you sure you want to delete this announcement?')) return;
            const courseId = document.getElementById('uploadCourseId') ? document.getElementById('uploadCourseId').value : '<?php echo (int)($course['course_id'] ?? 1); ?>';
            const formData = new FormData();
            formData.append('action_type', 'delete_announcement');
            formData.append('announcement_id', annId);
            formData.append('course_id', courseId);
            formData.append('is_ajax', '1');

            fetch('index.php?action=manage_course&id=' + courseId, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json().catch(() => ({ success: true })))
            .then(() => {
                const card = btn.closest('.cm-ann-card');
                if (card) {
                    card.style.transition = 'all 0.25s ease';
                    card.style.opacity = '0';
                    card.style.transform = 'translateX(20px)';
                    setTimeout(() => {
                        card.remove();
                        updateAnnouncementCount();
                    }, 250);
                }
            })
            .catch(() => {
                const card = btn.closest('.cm-ann-card');
                if (card) card.remove();
                updateAnnouncementCount();
            });
        }

        function updateAnnouncementCount() {
            const badge = document.getElementById('announcementBadgeCount');
            const cards = document.querySelectorAll('.cm-ann-card');
            const newCount = cards.length;
            if (badge) badge.textContent = newCount + ' active';
            if (newCount === 0) {
                const emptyMsg = document.getElementById('emptyAnnouncementsMsg');
                if (emptyMsg) emptyMsg.style.display = 'block';
            }
        }

        // Add Lecture Topic
        function openAddLectureModal() {
            document.getElementById('newLectureTitle').value = '';
            document.getElementById('addLectureModal').classList.add('open');
            document.getElementById('newLectureTitle').focus();
        }

        function closeAddLectureModal() {
            document.getElementById('addLectureModal').classList.remove('open');
        }

        function confirmAddLecture() {
            const title = document.getElementById('newLectureTitle').value.trim();
            const status = document.getElementById('newLectureStatus').value;
            const courseId = document.getElementById('uploadCourseId') ? document.getElementById('uploadCourseId').value : '<?php echo (int)($course['course_id'] ?? 1); ?>';

            if (!title) {
                alert('Please enter a title for the lecture.');
                return;
            }

            const formData = new FormData();
            formData.append('action_type', 'add_lecture_topic');
            formData.append('course_id', courseId);
            formData.append('lecture_title', title);
            formData.append('lecture_status', status);
            formData.append('is_ajax', '1');

            fetch('index.php?action=manage_course&id=' + courseId, {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success && data.lecture) {
                    renderNewLectureInDOM(data.lecture);
                    closeAddLectureModal();
                } else {
                    location.reload();
                }
            })
            .catch(() => {
                location.reload();
            });
        }

        function renderNewLectureInDOM(lec) {
            const container = document.getElementById('lecturesListContainer');
            const card = document.createElement('div');
            card.className = 'cm-section-card open';
            card.id = lec.id;
            const statusClass = lec.status.toLowerCase();

            card.innerHTML = `
                <div class="cm-section-header" onclick="toggleSection('${lec.id}')">
                    <div class="cm-section-title-wrap">
                        <span class="cm-chevron">▲</span>
                        <span class="cm-section-name">${escapeHtml(lec.title)}</span>
                        <span class="cm-section-status-badge ${statusClass}">${escapeHtml(lec.status)}</span>
                    </div>
                    <div class="cm-section-tools" onclick="event.stopPropagation()">
                        <button type="button" class="cm-tool-btn" onclick="editLectureTitle('${lec.id}', '${escapeHtml(lec.title)}')">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                        </button>
                        <button type="button" class="cm-tool-btn" onclick="toggleLectureLock(this)">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path><line x1="1" y1="1" x2="23" y2="23"></line></svg>
                        </button>
                    </div>
                </div>
                <div class="cm-section-body">
                    <div class="cm-items-container" id="items-${lec.id}"></div>
                    <div class="cm-upload-resource-row">
                        <button type="button" class="cm-btn-upload-resource" onclick="openUploadModal('${lec.id}', '${escapeHtml(lec.title)}')">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><polyline points="17 8 12 3 7 8"></polyline><line x1="12" y1="3" x2="12" y2="15"></line></svg>
                            <span>+ Upload File / Resource to ${escapeHtml(lec.title)}</span>
                        </button>
                    </div>
                </div>
            `;
            container.appendChild(card);
        }

        // Delete lecture card
        function deleteLectureSection(id) {
            if (confirm('Are you sure you want to delete this entire lecture and its materials?')) {
                const el = document.getElementById(id);
                if (el) el.remove();
            }
        }

        // Modals
        function openSettingsModal() {
            document.getElementById('settingsModal').classList.add('open');
        }

        function closeSettingsModal() {
            document.getElementById('settingsModal').classList.remove('open');
        }

        // Inline edit prompts with persistent backend saving
        function renameSection(id, currentName) {
            const newName = prompt('Enter new name for section:', currentName);
            if (!newName || !newName.trim() || newName.trim() === currentName) return;
            const cleanName = newName.trim();
            const el = document.querySelector('#' + id + ' .cm-section-name');
            if (el) el.textContent = cleanName;

            const courseId = document.getElementById('uploadCourseId') ? document.getElementById('uploadCourseId').value : '<?php echo (int)($course['course_id'] ?? 1); ?>';
            const formData = new FormData();
            formData.append('action_type', 'rename_section');
            formData.append('course_id', courseId);
            formData.append('section_id', id);
            formData.append('new_title', cleanName);
            formData.append('is_ajax', '1');

            fetch('index.php?action=manage_course&id=' + courseId, {
                method: 'POST',
                body: formData
            }).catch(err => console.error('Error saving section title:', err));
        }

        function editItemPrompt(btn, currentName) {
            const newName = prompt('Edit resource name:', currentName);
            if (!newName || !newName.trim() || newName.trim() === currentName) return;
            const cleanName = newName.trim();
            const row = btn.closest('.cm-item-row');
            const nameEl = row ? row.querySelector('.cm-item-name') : null;
            if (nameEl) nameEl.textContent = cleanName;

            const courseId = document.getElementById('uploadCourseId') ? document.getElementById('uploadCourseId').value : '<?php echo (int)($course['course_id'] ?? 1); ?>';
            const itemId = row ? (row.getAttribute('data-item-id') || row.id) : '';

            const formData = new FormData();
            formData.append('action_type', 'rename_lecture_item');
            formData.append('course_id', courseId);
            formData.append('item_id', itemId);
            formData.append('old_title', currentName);
            formData.append('new_title', cleanName);
            formData.append('is_ajax', '1');

            fetch('index.php?action=manage_course&id=' + courseId, {
                method: 'POST',
                body: formData
            }).catch(err => console.error('Error saving item title:', err));
        }

        function editLectureTitle(id, currentTitle) {
            const newTitle = prompt('Edit lecture title:', currentTitle);
            if (!newTitle || !newTitle.trim() || newTitle.trim() === currentTitle) return;
            const cleanTitle = newTitle.trim();
            const el = document.querySelector('#' + id + ' .cm-section-name');
            if (el) el.textContent = cleanTitle;

            const courseId = document.getElementById('uploadCourseId') ? document.getElementById('uploadCourseId').value : '<?php echo (int)($course['course_id'] ?? 1); ?>';
            const formData = new FormData();
            formData.append('action_type', 'rename_lecture');
            formData.append('course_id', courseId);
            formData.append('lecture_id', id);
            formData.append('new_title', cleanTitle);
            formData.append('is_ajax', '1');

            fetch('index.php?action=manage_course&id=' + courseId, {
                method: 'POST',
                body: formData
            }).catch(err => console.error('Error saving lecture title:', err));
        }

        function toggleVisibility(btn) {
            alert('Visibility status toggled for this section.');
        }

        function toggleItemVisibility(btn) {
            alert('Resource visibility toggled.');
        }

        function toggleLectureLock(btn) {
            const card = btn.closest('.cm-section-card');
            const badge = card.querySelector('.cm-section-status-badge');
            if (badge) {
                if (badge.classList.contains('locked')) {
                    badge.classList.remove('locked');
                    badge.classList.add('active');
                    badge.textContent = 'ACTIVE';
                } else if (badge.classList.contains('active')) {
                    badge.classList.remove('active');
                    badge.classList.add('upcoming');
                    badge.textContent = 'UPCOMING';
                } else {
                    badge.classList.remove('upcoming');
                    badge.classList.add('locked');
                    badge.textContent = 'LOCKED';
                }
            }
        }

        function escapeHtml(text) {
            if (!text) return '';
            return String(text)
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }
    </script>
</body>
</html>
