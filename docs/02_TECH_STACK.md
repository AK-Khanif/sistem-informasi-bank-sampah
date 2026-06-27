# 02_TECH_STACK.md

# Technical Stack & Architecture Decisions

## Sistem Informasi Bank Sampah RW 05

---

# Core Stack

| Layer          | Technology     |
| -------------- | -------------- |
| Language       | PHP 8.4+       |
| Framework      | Laravel 13     |
| Database       | MySQL 8.4 LTS  |
| Frontend       | Blade          |
| UI             | Tailwind CSS 4 |
| Interactive UI | Livewire 3     |
| JavaScript     | Alpine.js      |
| Icons          | Heroicons      |
| Charts         | Chart.js       |

---

# Laravel Packages

## Authentication

Laravel Breeze

## Authorization

Spatie Laravel Permission

## Export

Laravel Excel

Barryvdh DomPDF

## Development

Laravel Debugbar

Laravel Pint

PHPStan

## Monitoring (Production)

Laravel Pulse

Laravel Telescope

---

# Architecture

Clean Architecture

MVC

Service Layer

Repository Pattern

Dependency Injection

DTO (bila diperlukan)

Form Request Validation

Policy Authorization

Resource API

---

# Database Standard

Engine

InnoDB

Charset

utf8mb4

Primary Key

UUID

Soft Delete

Enabled

Timestamp

Enabled

---

# Code Standard

PSR-12

Laravel Pint

SOLID

DRY

KISS

Convention over Configuration

---

# Frontend Standard

Blade Components

Livewire Components

Reusable Layout

Reusable Form Components

Responsive Design

Desktop First

Mobile Friendly

---

# Security

Authentication

RBAC

CSRF

XSS Protection

SQL Injection Prevention

Password Hashing

Activity Log

Validation

---

# Performance

Pagination

Eager Loading

Database Index

Caching

Queue

Scheduler

---

# Testing

Feature Test

Unit Test

Browser Test (Future)

---

# Deployment

Ubuntu 24.04 LTS

Nginx

PHP-FPM

MySQL

Let's Encrypt

GitHub Actions (Future)

---

# Version Control

Git

Branch Strategy

main

develop

feature/*

release/*

hotfix/*

---

# Design Principles

* Simple
* Maintainable
* Extensible
* Secure
* Scalable
* Testable
* Readable

---

# Technical Philosophy

> Prioritaskan solusi bawaan Laravel sebelum menggunakan package pihak ketiga.

> Hindari kompleksitas yang tidak diperlukan.

> Seluruh business logic berada pada Service Layer.

> Controller hanya bertanggung jawab menerima request dan mengembalikan response.

> Gunakan Repository hanya ketika memberikan manfaat nyata terhadap maintainability dan pengujian.

> Semua perubahan database dilakukan melalui Migration.

> Semua validasi menggunakan Form Request.

> Semua authorization menggunakan Policy atau Gate.

> Semua fitur baru harus memiliki pengujian (Feature Test) sebelum dinyatakan selesai.