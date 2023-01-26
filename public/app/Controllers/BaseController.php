<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Modules\ManajemenAkun\Models\ManajemenAkunModel;
use Psr\Log\LoggerInterface;


/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
class BaseController extends Controller
{

    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;
    protected $manajemenAkunModel;
    protected $emailUser;
    protected $usr;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['auth', 'number', 'validation', 'time', 'user', 'program_kuliah', 'prodi', 'kurikulum', 'waktu_kuliah', 'krs', 'khs', 'admin', 'keu', 'kelompok_kuliah', 'jenis_biaya', 'curl', 'maja'];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);
        $this->manajemenAkunModel = new ManajemenAkunModel();
        $this->usr = $this->manajemenAkunModel->getUserDetail(['users.id' => user()->id])->get()->getResult()[0];
        $this->emailUser = $this->usr->email;

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
    }

    public function fetchMenu()
    {
        $data = file_get_contents(ROOTPATH . $this->getFile($this->usr->name));
        $data = json_decode($data, false);

        if ($this->usr->name != 'Mahasiswa' && $this->usr->name != 'Admin Keu') {
            $titles = [];
            $parents = [];
            $childs = [];

            foreach ($data as $resource) {
                if ($resource->parent == 0 && $resource->level == 'title') {
                    $titles[] = $resource;
                }

                if ($resource->parent != 0 && $resource->level == 'parent') {
                    $parents[] = $resource;
                }

                if ($resource->parent != 0 && $resource->level == 'child') {
                    $childs[] = $resource;
                }
            }
            // dd($titles, $parents, $childs);

            $menu = "";
            $menu .=
                '<li class=" ">
                <a href="/dashboard">
                    <i class="las la-home iq-arrow-left"></i><span>Dashboard</span>
                </a>
            </li>';
            foreach ($titles as $title) {
                $menu .=
                    '<li class=" ">
                    <a href="#'  . $title->level . $title->id . '" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <i class="' . $title->icon . '"></i><span>' . $title->nama . '</span>
                        <i class="las la-plus iq-arrow-right arrow-active"></i>
                        <i class="las la-minus iq-arrow-right arrow-hover"></i>
                    </a>
                    <ul id="' . $title->level . $title->id . '" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">';
                foreach ($parents as $parent) {
                    if ($title->id == $parent->parent && $parent->type == 'with-child') {
                        $menu .= '<li class=" ">
                            <a href="#' . $parent->level . $parent->id . '" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <i class="' . $parent->icon . '"></i><span>' . $parent->nama . '</span>
                                <i class="las la-plus iq-arrow-right arrow-active"></i>
                                <i class="las la-minus iq-arrow-right arrow-hover"></i>
                            </a>
                            <ul id="parent' . $parent->id . '" class="iq-submenu iq-submenu-data collapse" data-parent="#' . $title->level . $title->id . '">';
                        foreach ($childs as $child) {
                            if ($parent->id == $child->parent) {
                                if ($child->status) {
                                    $menu .= '<li class=" ">
                                        <a href="' . $child->pages . '">
                                            <span>' . $child->nama . '</span>
                                        </a>
                                    </li>';
                                } else {
                                    $menu .= '<li class=" ">
                                        <a href="/maintenance">
                                            <span>' . $child->nama . '</span>
                                        </a>
                                    </li>';
                                }
                            }
                        }
                        $menu .= '</ul></li>';
                    } elseif ($title->id == $parent->parent && $parent->type == 'no-child') {
                        if ($parent->status) {
                            $menu .= '<li class=" "><a href="' . $parent->pages . '"><i class="' . $parent->icon . '"></i><span>' . $parent->nama . '</span></a></li>';
                        } else {
                            $menu .= '<li class=" "><a href="/maintenance"><i class="' . $parent->icon . '"></i><span>' . $parent->nama . '</span></a></li>';
                        }
                    }
                }
                $menu .= '</ul></li>';
            }
        } elseif ($this->usr->name == 'Admin Keu') {
            $titles = [];
            $parents = [];
            $childs = [];

            foreach ($data as $resource) {
                if ($resource->parent == 0 && $resource->level == 'title') {
                    $titles[] = $resource;
                }

                if ($resource->parent != 0 && $resource->level == 'parent') {
                    $parents[] = $resource;
                }

                if ($resource->parent != 0 && $resource->level == 'child') {
                    $childs[] = $resource;
                }
            }
            // dd($titles, $parents, $childs);
            $menu = "";
            $menu .=
                '<li class=" ">
                <a href="/dashboard">
                    <i class="las la-home iq-arrow-left"></i><span>Dashboard</span>
                </a>
            </li>';
            foreach ($titles as $title) {
                if ($title->type == 'no-child') {
                    $menu .=
                        '<li class=" ">
                <a href="' . $title->pages . '">
                    <i class="' . $title->icon . ' iq-arrow-left"></i><span>' . $title->nama . '</span>
                </a>
            </li>';
                } elseif ($title->type == 'with-child') {
                    $menu .=
                        '<li class=" ">
                    <a href="#'  . $title->level . $title->id . '" class="collapsed" data-toggle="collapse" aria-expanded="false">
                        <i class="' . $title->icon . '"></i><span>' . $title->nama . '</span>
                        <i class="las la-plus iq-arrow-right arrow-active"></i>
                        <i class="las la-minus iq-arrow-right arrow-hover"></i>
                    </a>
                    <ul id="' . $title->level . $title->id . '" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">';
                    foreach ($parents as $parent) {
                        if ($title->id == $parent->parent && $parent->type == 'with-child') {
                            $menu .= '<li class=" ">
                            <a href="#' . $parent->level . $parent->id . '" class="collapsed" data-toggle="collapse" aria-expanded="false">
                                <i class="' . $parent->icon . '"></i><span>' . $parent->nama . '</span>
                                <i class="las la-plus iq-arrow-right arrow-active"></i>
                                <i class="las la-minus iq-arrow-right arrow-hover"></i>
                            </a>
                            <ul id="parent' . $parent->id . '" class="iq-submenu iq-submenu-data collapse" data-parent="#' . $title->level . $title->id . '">';
                            foreach ($childs as $child) {
                                if ($parent->id == $child->parent) {
                                    if ($child->status) {
                                        $menu .= '<li class=" ">
                                        <a href="' . $child->pages . '">
                                            <span>' . $child->nama . '</span>
                                        </a>
                                    </li>';
                                    } else {
                                        $menu .= '<li class=" ">
                                        <a href="/maintenance">
                                            <span>' . $child->nama . '</span>
                                        </a>
                                    </li>';
                                    }
                                }
                            }
                            $menu .= '</ul></li>';
                        } elseif ($title->id == $parent->parent && $parent->type == 'no-child') {
                            if ($parent->status) {
                                $menu .= '<li class=" "><a href="' . $parent->pages . '"><i class="' . $parent->icon . '"></i><span>' . $parent->nama . '</span></a></li>';
                            } else {
                                $menu .= '<li class=" "><a href="/maintenance"><i class="' . $parent->icon . '"></i><span>' . $parent->nama . '</span></a></li>';
                            }
                        }
                    }
                    $menu .= '</ul></li>';
                }
            }
        } else {
            $menu = "";
            $jumlah = count($data);
            $no = 0;
            foreach ($data as $resource) {
                $action = "showModal('" . $resource->title . "')";
                $no++;
                $menu .= ($jumlah == $no && $no % 2 == 1) ? '<div class="col-12 col-sm-12 col-md-12 col-lg-3 col-xl-3">' : '<div class="col-6 col-sm-6 col-md-6 col-lg-3 col-xl-3">';
                $menu .= '<div class="card p-3 rounded position-relative overflow-hidden" style="cursor:pointer" onclick="' . $action . '">';
                $menu .= '<span class="iq-overlay-image-block">';
                $menu .= '<i class="' . $resource->icon . '"></i>';
                $menu .= '</span>';
                $menu .= '<div class="icon iq-icon-box rounded text-center mb-3" style="background-color:#' . $resource->color . ';opacity:0.9">';
                $menu .= '<i class="' . $resource->icon . '" style="color:#FFFFFF"></i>';
                $menu .= '</div>';
                $menu .= '<strong>' . $resource->title . '</strong>';
                $menu .= '<small class="label mt-1 text-truncate" style="color:#' . $resource->color . '">' . $resource->subTitle . '</small>';
                $menu .= '</div>';
                $menu .= '</div>';
            }
        }
        return $menu;
    }

    public function getFile($usr)
    {
        switch ($usr) {
            case "General User":
                $file = "public/menu/menuGeneralUser.json";
                break;
            case "Superadmin":
                $file = "public/menu/menuSuperadmin.json";
                break;
            case "Kepala Biro":
                $file = "public/menu/menuKepalaBiro.json";
                break;
            case "WR II":
                $file = "public/menu/menuWr2.json";
                break;
            case "Pegawai":
                $file = "public/menu/menuPegawai.json";
                break;
            case "Admin Keu":
                $file = "public/menu/menuAdminKeu.json";
                break;
            case "Admin Anggaran":
                $file = "public/menu/menuAdminAnggaran.json";
                break;
            case "Dekan":
                $file = "public/menu/menuDekan.json";
                break;
            case "Dosen":
                $file = "public/menu/menuDosen.json";
                break;
            case "Rektorat":
                $file = "public/menu/menuRektorat.json";
                break;
            case "Fakultas":
                $file = "public/menu/menuFakultas.json";
                break;
            case "Admin Pegawai":
                $file = "public/menu/menuAdminPegawai.json";
                break;
            case "Biro":
                $file = "public/menu/menuBiro.json";
                break;
            case "Mahasiswa":
                $file = "public/menu/menuMahasiswa.json";
                break;
            default:
                $file = "public/menu/menuGeneralUser.json";
        }
        return $file;
    }

    protected $numberPage = 25;

    protected $apiKey = 'xnd_development_Ei5XAfgqElWW4tuZt6IqpAR5LMPfK8tJ0S2Y0LrzheA2dgf5xAWISMfwqSA';
    // protected $hitungTagihanNumberPage = 1000;
}
