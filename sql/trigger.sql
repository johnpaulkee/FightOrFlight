CREATE OR REPLACE TRIGGER log_hq_update
  AFTER UPDATE OF name ON Airline_Headquartered_In
  FOR EACH ROW
BEGIN
  INSERT INTO AirlineHQ_log(Log_date, aCode, aName, hqName)
  VALUES (SYSDATE, :NEW.airline_code, :NEW.airline_name, :NEW.name)
END;
