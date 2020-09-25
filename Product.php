<?php
class Product
{
    protected $db;
    protected $host;
    protected $user;
    protected $password;


    protected $connect;
    protected $stmt;

    protected $res;

    /**
     * Koneksi ke database
     *
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $db
     */
    public function __construct($host, $user, $password, $db)
    {
        $this->connect = new PDO("mysql:host=$host;dbname=$db", $user, $password);
        $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connect->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $this->connect;
    }

    /**
     * Menampilkan data dari database
     *
     * @return array
     */
    public function index()
    {
        $this->stmt = $this->connect->prepare("SELECT * FROM produk ORDER BY nama_produk ASC");
        $this->stmt->execute();
        $this->res = $this->stmt->fetchAll();

        return $this->res;
    }

    /**
     * Menghapus daya
     *
     * @param int|string $id
     * @return array
     */
    public function show($id)
    {
        $this->stmt = $this->connect->prepare("SELECT * FROM produk WHERE id = ?");
        $this->stmt->execute([$id]);
        $this->res = $this->stmt->fetch();

        if ($this->res) {
            return $this->res;
        }
    }

    /**
     * Menyimpan data
     *
     * @param array $request
     * @return header
     */
    public function store($request)
    {
        $this->stmt = $this->connect->prepare("INSERT INTO produk VALUES(?,?,?,?,?)");
        $this->res = $this->stmt->execute([
            null,
            $request['nama_produk'],
            $request['keterangan'],
            $request['jumlah'],
            $request['harga'],
        ]);

        if ($this->res) {
            return $this->redirect(".");
        }

        return $this->redirect(".?action=add&method=store&error=true");
    }

    /**
     * Memperbarui data
     *
     * @param array $request
     * @return array
     */
    public function update($request)
    {
        $this->stmt = $this->connect->prepare("UPDATE produk SET nama_produk = ?, keterangan = ?, harga = ?, jumlah = ? WHERE id = ?");
        $this->res =  $this->stmt->execute([
            $request['nama_produk'],
            $request['keterangan'],
            $request['harga'],
            $request['jumlah'],
            $request['id']
        ]);

        if ($this->res) {
            return $this->redirect(".");
        }

        return $this->redirect(".?action=update&method=update&error=true");
    }

    /**
     * Menghapus daya
     *
     * @param int|string $id
     * @return array
     */
    public function destroy($id)
    {
        $this->stmt = $this->connect->prepare("DELETE FROM produk WHERE id = ?");
        $this->res = $this->stmt->execute([$id]);

        if ($this->res) {
            return $this->redirect(".");
        }

        return $this->redirect(".?action=update&method=update&error=true");
    }

    /**
     * Memindahkan halaman
     *
     * @param string $url
     */
    public function redirect($url)
    {
        header("location: $url");
    }
}
