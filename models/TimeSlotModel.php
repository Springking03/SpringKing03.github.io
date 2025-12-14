<?php
require_once __DIR__ . '/../core/Database.php';
class TimeSlotModel extends Database
{
    const TABLE_NAME = 'time_slots';

    protected $connection = null;

    public function __construct()
    {
        $this->connection = $this->connect();
    }

    private function _query($sql)
    {
        return mysqli_query($this->connection, $sql);
    }

    public function getAll()
    {
        $sql = "SELECT *
        FROM time_slots";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();

        $timeSlots = [];
        while ($row = $result->fetch_assoc()) {
            $timeSlot = date("H:i", strtotime($row['slot_time']));
            $timeSlots[] = $timeSlot;
        }

        $stmt->close();
        return $timeSlots;
    }

   public function getByDateAndDoctor($date_slot, $doctorId)
{
    $sql = "SELECT ts.slot_time
            FROM appointments a
            JOIN time_slots ts ON a.time_id = ts.time_id
            WHERE a.date_slot = ?
              AND a.employee_id = ?
              AND a.status IN (0,1,2)";  // chặn các lịch còn hiệu lực

    $stmt = $this->connection->prepare($sql);
    $stmt->bind_param("ii", $date_slot, $doctorId);
    $stmt->execute();
    $result = $stmt->get_result();

    $timeSlots = [];
    while ($row = $result->fetch_assoc()) {
        $timeSlots[] = date("H:i", strtotime($row['slot_time']));
    }
    $stmt->close();
    return $timeSlots;
}

}