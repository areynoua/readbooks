-----------
-- Users --
-----------

-- TODO

-----------
-- Works --
-----------

CREATE TABLE Persons (
  id_               SERIAL  PRIMARY KEY,
  name              TEXT    NOT NULL CHECK (name <> ""),
  wikidata          TEXT    UNIQUE
);

CREATE TABLE Companies (
  id_               SERIAL  PRIMARY KEY,
  name              TEXT    NOT NULL CHECK (name <> ""),
  wikidata          TEXT    UNIQUE
);

CREATE TABLE PublicationTypes (
  id_               SERIAL  PRIMARY KEY,
  name              TEXT    NOT NULL CHECK (name <> "")
);
INSERT INTO PublicationTypes(id_, name) VALUES
  (1, "conference"),
  (2, "journal"),
  (3, "book"),

-- E.g.: the "Fundamenta Informaticæ" journal / the "Theory of Computation" book
CREATE TABLE Publications (
  id_               SERIAL  PRIMARY KEY,
  name              TEXT    NOT NULL,
  publication_type  INTEGER NOT NULL REFERENCES PublicationTypes(id_),
  publisher         INTEGER NOT NULL REFERENCES Companies(id_),
  ISSN              TEXT, -- TODO regex based CHECK                             -- e.g.: "0169-2968 (P) 1875-8681 (E)" / NULL
);

-- E.g.: the "Fundamenta Informaticae" 137 (2015) number 1 / the Second edition of "Theory of Computation"
CREATE TABLE Releases (
  id_               SERIAL  PRIMARY KEY,
  publication       INTEGER NOT NULL REFERENCES Publications(id_),
  num_1             INTEGER, -- volume / edition count                          -- e.g.: 137 / 2
  num_2             INTEGER, -- number / issue                                  -- e.g.: 1 / NULL
  name              TEXT,                                                       -- e.g.: "2015-1" / "Second"
  editor            INTEGER NOT NULL REFERENCES Companies(id_),
  date_month        INTEGER CHECK (1 <= date_month AND date_month <= 12),       -- e.g.: NULL / NULL
  date_year         INTEGER NOT NULL,                                           -- e.g.: 2015 / 2006
  ISBN              INTEGER,                                                    -- e.g.: NULL / 0619217642

  CHECK (num_1 NOT NULL OR (name NOT NULL AND name <> ""))
);

-- E.g.: an article in a journal, a chapter in a book
CREATE TABLE Works (
  id_               SERIAL  PRIMARY KEY,
  title             TEXT    NOT NULL CHECK (title <> ""),
  translator        INTEGER REFERENCES Persons(id_),
  translation_of    INTEGER REFERENCES Works(id_),

  CHECK (translator IS NULL OR translation_of IS NOT NULL)
);

-- Link works to their authors
-- An article may have many authors
CREATE TABLE Authors (
  work              INTEGER NOT NULL REFERENCES Works(id_),
  person            INTEGER NOT NULL REFERENCES Persons(id_),

  UNIQUE (work, person)
);

-- Link works to their releases
-- An article may appear in many journals
CREATE TABLE WorkReleases (
  work              INTEGER NOT NULL REFERENCES Works(id_),
  release           INTEGER NOT NULL REFERENCES Releases(id_)
);


-----------
-- Edits --
-----------

-- TODO: store a journal of edits with their authors
