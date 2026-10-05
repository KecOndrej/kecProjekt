<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Cyklo extends BaseController
{
    // 1. Hlavní stránka - pouze seznam ročníků s celkovou délkou
    public function index()
    {
        $db = \Config\Database::connect();

        $rocnikyQuery = $db->query("
            SELECT id, year, start_date, end_date, logo 
            FROM cp_race_year 
            WHERE id_race = 124 
            ORDER BY year DESC
        ");
        $rocniky = $rocnikyQuery->getResultArray();

        foreach ($rocniky as &$rocnik) {
            // Spočítáme celkovou délku pro daný ročník
            $delkaQuery = $db->query("
                SELECT SUM(distance) as celkova_delka 
                FROM cp_stage 
                WHERE id_race_year = ?
            ", [$rocnik['id']]);
            
            $delkaResult = $delkaQuery->getRowArray();
            $rocnik['celkova_delka'] = round((float)($delkaResult['celkova_delka'] ?? 0));
        }

        return view('pariz_nice', ['rocniky' => $rocniky]);
    }

    // 2. Detail jednoho ročníku - načte konkrétní ročník a jeho etapy
    public function detailRocniku($id_year)
    {
        $db = \Config\Database::connect();

        // Načteme ročník
        $rocnikQuery = $db->query("
            SELECT id, year, start_date, end_date, logo 
            FROM cp_race_year 
            WHERE id = ?
        ", [$id_year]);
        
        $rocnik = $rocnikQuery->getRowArray();

        if (!$rocnik) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Ročník nenalezen");
        }

        // Načteme etapy pro tento ročník
        $etapyQuery = $db->query("
            SELECT e.*, t.name as typ_etapy, r.last_name as vitez_prijmeni, r.first_name as vitez_jmeno
            FROM cp_stage e
            LEFT JOIN cp_parcour_type t ON e.parcour_type = t.id
            LEFT JOIN cp_result res ON (res.id_stage = e.id AND res.type_result = 1 AND res.rank = 1)
            LEFT JOIN cp_rider r ON res.id_rider = r.id
            WHERE e.id_race_year = ?
            ORDER BY e.number ASC
        ", [$id_year]);

        $rocnik['etapy'] = $etapyQuery->getResultArray();

        return view('detail_rocniku', ['rocnik' => $rocnik]);
    }

    public function pridatRocnik()
    {
        $db = \Config\Database::connect();

        // Vyfiltrování mužských závodů kategorie E (obsahují ME v base_name)
        $zavodyQuery = $db->query("
            SELECT id, base_name 
            FROM cp_testa_races 
            WHERE base_name LIKE '% ME%' OR base_name LIKE '% ME -%'
            ORDER BY base_name ASC
        ");

        $data['zavody'] = $zavodyQuery->getResultArray();

        return view('pridat_rocnik', $data);
    }

    public function ulozitRocnik()
    {
        $db = \Config\Database::connect();

        $idRace = $this->request->getPost('id_race');
        $realName = $this->request->getPost('real_name');
        $year = $this->request->getPost('year');
        $startDate = $this->request->getPost('start_date');
        $endDate = $this->request->getPost('end_date');

        $logoName = null;
        $file = $this->request->getFile('logo');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $logoName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $logoName);
        }

        $db->query("
            INSERT INTO cp_race_year (id_race, real_name, year, start_date, end_date, logo) 
            VALUES (?, ?, ?, ?, ?, ?)
        ", [$idRace, $realName, $year, $startDate, $endDate, $logoName]);

        return redirect()->to(base_url('index.php/cyklo'));
    }

    public function vysledky($id_stage, $type_result)
    {
        $db = \Config\Database::connect();

        $vysledkyQuery = $db->query("
            SELECT res.rank, res.time, r.first_name, r.last_name
            FROM cp_result res
            JOIN cp_rider r ON res.id_rider = r.id
            WHERE res.id_stage = ? AND res.type_result = ?
            ORDER BY res.rank ASC
        ", [$id_stage, $type_result]);

        $data['vysledky'] = $vysledkyQuery->getResultArray();
        $data['typ'] = ($type_result == 1) ? 'Pořadí v etapě' : 'Pořadí po etapě';

        return view('vysledky_etapy', $data);
    }
}