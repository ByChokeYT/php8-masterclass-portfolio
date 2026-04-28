-- Tabla de catálogo de minerales
CREATE TABLE IF NOT EXISTS minerals (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL UNIQUE,
    symbol TEXT NOT NULL,
    stock REAL DEFAULT 0.0,
    unit TEXT DEFAULT 'Kg'
);

-- Tabla de historial de movimientos (Transaccional)
CREATE TABLE IF NOT EXISTS inventory_logs (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    mineral_id INTEGER NOT NULL,
    type TEXT NOT NULL, -- 'IN' (Entrada), 'OUT' (Salida)
    quantity REAL NOT NULL,
    reason TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (mineral_id) REFERENCES minerals(id)
);

-- Semillas iniciales (Solo si la tabla está vacía)
INSERT OR IGNORE INTO minerals (name, symbol, stock) VALUES ('ESTAÑO', 'Sn', 0.0);
INSERT OR IGNORE INTO minerals (name, symbol, stock) VALUES ('ZINC', 'Zn', 0.0);
INSERT OR IGNORE INTO minerals (name, symbol, stock) VALUES ('PLATA', 'Ag', 0.0);
